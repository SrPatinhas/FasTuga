const { createServer } = require("http");
const { Server } = require("socket.io");
const { instrument } = require("@socket.io/admin-ui");
const axios = require("axios");

const httpServer = createServer();

const myEnv = require('./env.js');
let urlAxios = myEnv.env().url;

const io = new Server(httpServer, {
    cors: {
        origin: [
            "http://127.0.0.1:5173", // client app
            "http://172.22.21.147", // VM server
            "https://admin.socket.io" // Dashboard Socket.IO
        ],
        methods: ["GET", "POST"],
        credentials: true
    }
});
// Dashboard Socket.IO
instrument(io, {
    auth: false,
    mode: "development",
});

httpServer.listen(8081, () =>{
    console.log('listening on *:8081');
});

let SessionHandler = require("./SessionHandler.js");
let sessions = new SessionHandler();

io.on('connection', (socket) => {
    console.log(`client ${socket.id} has connected`);

    /****************************************
     *      Events to the "restaurant"      *
     ***************************************/
    /**
     * Events to the "restaurant_kitchen"
     **/
    socket.on('orderNew', (order) => {
        console.log(`new order`);
        io.emit('orderNew'); // sends the new order
    });
    /**
     * Events to the "restaurant_counter"
     **/
    socket.on('ticketNew', (ticket) => {
        io.to("restaurant").emit('ticketNew', ticket)
    });

    /*
     * Events to the "client"
     */
    socket.on('orderUpdateStatus', (user_id) => {
        console.log(`order status update`);
        const orderSession = sessions.getUserSession(user_id);
        console.log(orderSession);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('orderUpdateStatus'); // sends the new order
        }
    });
    socket.on('orderCanceled', (idUser_Order) =>{
        console.log(`order status cancelled`);
        const orderSession = sessions.getUserSession(idUser_Order);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('orderCanceled');
        }
    });
    socket.on('refundOrder', (idUser_Order, order) => {
        console.log(`order refunded`);
        const orderSession = sessions.getUserSession(idUser_Order);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('refundOrder', order);
        }
    });


    socket.on('ticketComplete', (idUser_Order, order) => {
        const orderSession = sessions.getUserSession(idUser_Order);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('ticketComplete', order);
        }
    });

    // tell all the users that there is a new product, to update the list
    socket.on('newProduct', () => {
        io.emit('updateProducts');
    });

    /*
     * Login user
     * Register Log
     * Join user to the correct room
     */
    socket.on('loggedIn', (user) => {
        if (user) {
            sessions.addUserSession(user, socket.id);
            socket.join(user.type);
            console.log("[LoggedIn] user_id: " + user.id + " | socketID: " + socket.id);
        }
    });

    socket.on('loggedOut', (user) => {
        if (user) {
            socket.leave(user.type);
            sessions.removeUserSession(user.id);
        }
    });

    socket.on('disconnect', (reason) => {
        let x = sessions.removeSocketIDSessionAndGetId(socket.id);
        if(x == null){
            return; // user fez logout antes de fechar a página.
        }
        console.log("[Disconnect] user_id: " + x.id + " | socketID: " + socket.id);
    });

    socket.on('changeBlockedStatus', (user) => {
        // verficar se user está logado
        let session = sessions.getUserSession(user.id);
        if (session && user.blocked == 1){
            io.to(`${session.socketID}`).emit('blockStatusUpdate')
        }
        //if another manager is logged
        io.to('EM').emit('updateUserList', user);
    });
})
const axios = require("axios");
const httpServer = require('http').createServer();

const myEnv = require('./env.js');
let urlAxios = myEnv.env().url;

const io = require("socket.io")(httpServer, {
    cors: {
        // The origin is the same as the Vue app domain:
        // Change if necessary
        origin: "http://127.0.0.1:5173",
        methods: ["GET", "POST"],
        //credentials: true
    }
})
httpServer.listen(8080, () =>{
    console.log('listening on *:8080');
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
        io.to("restaurant").emit('orderNew', order); // sends the new order
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
    socket.on('orderUpdateStatus', (order) => {
        const orderSession = sessions.getUserSession(order.user_id);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('orderUpdateStatus', order); // sends the new order
        }
    });
    socket.on('orderCanceled', (idUser_Order) =>{
        const orderSession = sessions.getUserSession(idUser_Order);
        if(orderSession){ // receives the id of the user to be notified
            io.to(orderSession.socketID).emit('orderCanceled');
        }
    });
    socket.on('refundOrder', (idUser_Order, order) => {
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
            //updated user availability
            //axios.put(urlAxios + '/api/updateLoggedAt', {"user_id": user.id, "logged": 1}).then(response =>{
                if (user.type == 'A') {
                    socket.join('administrator');
                }
            //}).catch(error => {
            //    console.log("Login - Error: " + error.data);
            //});
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
        console.log("[Disconnect] user_id: " + user.id + " | socketID: " + socket.id);
        //axios.put(urlAxios + '/api/updateLoggedAt', {"user_id": x.id, "logged": 0}).then(response =>{
            if(x.type !== "A"){
                io.to("restaurant").emit('update_incoming');
            }
        //}).catch(error => {
        //    console.log("disconnect - Error: " + error.data);
        //});
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
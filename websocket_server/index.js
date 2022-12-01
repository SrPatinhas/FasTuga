const httpServer = require('http').createServer()
const io = require("socket.io")(httpServer, {
    cors: {
        // The origin is the same as the Vue app domain:
        // Change if necessary
        origin: "http://127.0.0.1:8080",
        methods: ["GET", "POST"],
        credentials: true
    }
})
httpServer.listen(8080, () =>{
    console.log('listening on *:8080')
})
io.on('connection', (socket) => {
    console.log(`client ${socket.id} has connected`)
    socket.on('newProject', (project) => {
        socket.broadcast.emit('newProject', project)
    })
    socket.on('updateProject', (project) => {
        socket.broadcast.emit('updateProject', project)
    })
    socket.on('deleteProject', (project) => {
        socket.broadcast.emit('deleteProject', project)
    })
    socket.on('loggedIn', function (user) {
        socket.join(user.id)
        if (user.type == 'A') {
            socket.join('administrator')
        }
    })
    socket.on('loggedOut', function (user) {
        socket.leave(user.id)
        socket.leave('administrator')
    })
    socket.on('updateUser', function (user) {
        socket.in('administrator').except(user.id).emit('updateUser', user)
        socket.in(user.id).emit('updateUser', user)
    })
})
/**
 * Simple socket server for the scrum board, passes events on to all connected clients on a board
 * excluding the originator
 */

var io = require('socket.io').listen(8080);

/**
 * Map of client IDs to usernames
 * TODO: add a way of pruning old clientIds
 */
var usernames = {};

io.sockets.on('connection', function (socket) {

    /** 
     * Get the list of usernames connected to a room
     */
    var getCurrentUsers = function(room) {
        var currentClients = io.sockets.clients(room);
        var returnClients = [];

        for (var i = 0; i < currentClients.length; i++) {
            var client = currentClients[i];
            if (usernames[room][client.id] !== 'undefined') {
                returnClients.push(usernames[room][client.id]);
            }
        }
        return returnClients;
    }

    /**
     * Allow clients to subscribe to a specific board
     */
    socket.on('subscribe', function(room, username) {
        socket.join(room);
        if (typeof(usernames[room]) == 'undefined') {
            usernames[room] = {};
        }
        usernames[room][socket.id] = username;
        io.sockets.in(room).emit('user:change', getCurrentUsers(room));
    });

    /**
     * Allow clients to unsubscribe from a board
     */
    socket.on('unsubscribe', function(room) {
        socket.leave(room);
        delete usernames[room][socket.id];

        io.sockets.in(room).emit('user:change', getCurrentUsers(room));
    });

    socket.on('boardEvent', function(room, eventType, params) {
        io.sockets.in(room).except(socket.id).emit(eventType, params);
    });

});
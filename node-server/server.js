/**
 * Simple socket server for the scrum board, passes events on to all connected clients on a board
 */

var io = require('socket.io').listen(8080);

io.sockets.on('connection', function (socket) {
  
    //Allow clients to subscribe to a specific board
    socket.on('subscribe', function(data) { 
        socket.join(data);     
    });
  
    //Allow clients to unsubscribe from a board
    socket.on('unsubscribe', function(data) { 
        socket.leave(data); 
    });
  
    //Editing a ticket
    socket.on('ticket:change', function (room, ticket) {
        io.sockets.in(room).emit('ticket:change', ticket);
    });
  
    //Adding a new ticket
    socket.on('ticket:create', function (room, ticket) {
        io.sockets.in(room).emit('ticket:create', ticket);
    });
  
    //Deleting a ticket
    socket.on('ticket:delete', function (room, ticketId) {
        io.sockets.in(room).emit('ticket:delete', ticketId);
    });
});
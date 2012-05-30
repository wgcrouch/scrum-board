var io = require('socket.io').listen(8080);

io.sockets.on('connection', function (socket) {
  socket.on('ferret', function (name, fn) {
    fn('woot');
  });
  
  socket.on('ticket:change', function (ticket) {
     socket.broadcast.emit('ticket:change', ticket);
  });
  
  socket.on('ticket:create', function (ticket) {
     socket.broadcast.emit('ticket:create', ticket);
  });
  
  socket.on('ticket:delete', function (ticketId) {
     socket.broadcast.emit('ticket:delete', ticketId);
  });
});
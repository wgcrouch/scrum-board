/**
 * Controller for viewing a scrum board
 * 
 * Initializes the board view and board model
 */
itsallagile.Controller.Scrumboard = itsallagile.baseObject.extend({
    
    board : null,
    
    load: function() {
        
        this.boardView = new itsallagile.View.Board({
            model: this.board,
            statuses: this.statuses,
            id: 'board-' + this.board.get("id")
        });
        
        $('#board-container').html(this.boardView.render().el);
        
//        itsallagile.socket = io.connect(window.location.hostname + ':8080'); 
//        board.render();   
//        itsallagile.socket.emit('subscribe', board.getRoomId());  
//        this.initHandlers();
    }
    
    
});



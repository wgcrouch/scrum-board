/**
 * Controller for viewing a scrum board
 * 
 * Initializes the board view and board model
 */
itsallagile.Controller.Scrumboard = itsallagile.baseObject.extend({
    
    board : null,
    boardView: null,
    toolbarView: null,
    
    load: function() {
        var container = $('#board-container');
        this.toolbarView = new itsallagile.View.Toolbar({
            templates: [
                new itsallagile.View.Template({type: 'task'}),
                new itsallagile.View.Template({type: 'test'}),
                new itsallagile.View.Template({type: 'bug'}),
                new itsallagile.View.Template({type: 'defect'}),
                new itsallagile.View.Template({type: 'design'}),
            ]
        });  
        
        this.boardView = new itsallagile.View.Board({
            model: this.board,
            statuses: this.statuses,
            id: 'board-' + this.board.get("id")
        });
        
        container.append(this.toolbarView.render().el);
        container.append(this.boardView.render().el);
        
//        itsallagile.socket = io.connect(window.location.hostname + ':8080'); 
//        board.render();   
//        itsallagile.socket.emit('subscribe', board.getRoomId());  
//        this.initHandlers();
    }
    
    
});



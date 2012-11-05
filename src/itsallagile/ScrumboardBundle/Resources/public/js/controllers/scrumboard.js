/**
 * Controller for viewing a scrum board
 * 
 * Initializes the board view and board model
 */
itsallagile.Controller.Scrumboard = itsallagile.baseObject.extend({
    
    board : null,
    boardView: null,
    toolbarView: null,
    connectedUsersView: null,
    messagesView: null,
    
    load: function() {        
        var container = $('#board-container');
        
        this.toolbarView = new itsallagile.View.Toolbar({
            model: this.board,
            templates: [
                new itsallagile.View.Template({type: 'task'}),
                new itsallagile.View.Template({type: 'test'}),
                new itsallagile.View.Template({type: 'bug'}),
                new itsallagile.View.Template({type: 'defect'}),
                new itsallagile.View.Template({type: 'design'}),
            ]
        });

        this.connectedUsersView = new itsallagile.View.ConnectedUsers();

        this.messagesView = new itsallagile.View.ChatBox({messages: this.board.get('chatMessages'), board: this.board});
        this.boardView = new itsallagile.View.Board({
            model: this.board,
            statuses: this.statuses,
            id: 'board-' + this.board.get("id")
        });

        container.append(this.toolbarView.render().el);
        container.append(this.boardView.render().el);
        container.append(this.connectedUsersView.render().el);
        container.append(this.messagesView.render().el);
        container.append('<div id="notification-container"></div>');

        //Open a socket 
        itsallagile.socket = io.connect(window.location.hostname + ':8080');

        itsallagile.roomId = 'board:' +  this.board.get("id");
        itsallagile.socket.on('connect', _.bind(this.onSocketConnect, this));
    },

    //Handler for socket connections and reconnections
    onSocketConnect: function() {
        //Join the room for this scrumboard
        itsallagile.socket.emit('subscribe', itsallagile.roomId, this.user);

        //We now have a socket so bind on events from it
        this.boardView.bindSocketEvents();
        this.connectedUsersView.bindSocketEvents();
        this.messagesView.bindSocketEvents();
    }    
    
});



itsallagile.View.ChatBox = Backbone.View.extend({
    tagName: 'div',
    template: '<div id="chat-handle">Chat</div>' +
        '<div id="chat-window"><div id="chat-messages"></div>' + 
        '<form name="chat-input"><div id="message-input-area"><input id="message-input" value=""/><input id="message-submit" type="submit" value="&gt;"/></form></div></div>',
    id: 'chatbox',
    events: {
        'click #chat-handle' : 'toggleShowChat',
        'submit form': 'newMessage'
    },
    board: null,
    messages: null,
    
    initialize: function(options) { 
        this.board = options.board;
        this.messages = options.messages;
        this.messages.bind('add', this.renderNewMessage, this);
    },
    
    render: function() {
        this.$el.html(_.template(this.template));
        
        var messageList = $('#chat-messages', this.$el);
        messageList.html('');
        if (typeof this.messages !== 'undefined') {
            this.messages.forEach(function(message) {
                var template = new itsallagile.View.ChatMessage({model: message});
                messageList.append(template.render().el);
            });
        }
        return this;
    },
    
    /**
     * Bind to events coming in from the socket connection
     */
    bindSocketEvents: function() {
        var socket = itsallagile.socket;        
        if (typeof socket !== 'undefined') {
            socket.on('chatMessage:create', _.bind(this.remoteCreate, this));
        }
    },
    
    toggleShowChat: function() {
        $('#chat-window', this.$el).slideToggle();
    },
    
    newMessage: function(event) {
        event.preventDefault();
        event.stopPropagation();
        var textbox = $('#message-input', this.$el);
        if (textbox.val() != '') {
            var message = new itsallagile.Model.ChatMessage({
                content: textbox.val(),
                boardId: this.board.get('id')
            });
            message.save(null, {silent:true, success: _.bind(this.onCreateSuccess, this)});
            this.messages.add(message, {silent: true});
            textbox.val('');
        }
    },
   
    onCreateSuccess: function(message) {
        this.renderNewMessage(message);
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('chatMessage:create', itsallagile.roomId, message);
        }
    },
    
    remoteCreate: function(message) {
        var newMessage = new itsallagile.Model.ChatMessage(message);
        this.messages.add(newMessage);
    },
    
    renderNewMessage: function(message) {
        var view = new itsallagile.View.ChatMessage({model: message});
        var messageBox = $('#chat-messages', this.$el)
        messageBox.append(view.render().el);    
        messageBox.prop('scrollTop', messageBox.prop('scrollHeight'));
    }
});



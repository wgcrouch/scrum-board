/**
 * View object for the chat box
 */
itsallagile.View.ChatBox = Backbone.View.extend({
    tagName: 'div',
    template: '<div id="chat-handle" class="live-box-heading">Chat</div>' +
        '<div id="chat-window"><div id="chat-messages"></div>' +
        '<form name="chat-input"><div id="message-input-area"><input id="message-input" value=""/><input id="message-submit" type="submit" value="&gt;" class="btn"/></form></div></div>',
    id: 'chatbox',

    events: {
        'click #chat-handle' : 'toggleShowChat',
        'submit form': 'newMessage'
    },

    board: null,
    messages: null,

    /**
     * Initialize params and bind on collection events
     */
    initialize: function(options) {
        this.board = options.board;
        this.messages = options.messages;
        this.messages.bind('add', this.renderNewMessage, this);
    },

    /**
     * Render the chat box, and render any messages using the sub view
     **/
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

    /**
     * Show/hide the chat box when the title bar is clicked
     */
    toggleShowChat: function() {

        var window = $('#chat-window', this.$el);
        window.slideToggle();
        var handle = $('#chat-handle', this.$el);
        handle.removeClass('new-message');
        //Scroll to the latest message
        var messageBox = $('#chat-messages', this.$el);
        messageBox.prop('scrollTop', messageBox.prop('scrollHeight'));
        if (window.is(':visible')) {
            $('#message-input', window).focus();
        }

    },

    /**
     * When the user submits a new chat message, save it and add it to the collection
     */
    newMessage: function(event) {
        event.preventDefault();
        event.stopPropagation();
        var textbox = $('#message-input', this.$el);
        if (textbox.val() != '') {
            var message = new itsallagile.Model.ChatMessage({
                content: textbox.val(),
                board: this.board.get('id')
            });
            message.save(null, {silent:true, success: _.bind(this.onCreateSuccess, this)});
            this.messages.add(message, {silent: true});
            textbox.val('');
        }
    },

   /**
    * Send a socket message when a new ticket is created
    */
    onCreateSuccess: function(message) {
        this.renderNewMessage(message);
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('boardEvent', itsallagile.roomId, 'chatMessage:create', {message: message});
        }
    },

    /**
     * Handler for a message created by a different user
     */
    remoteCreate: function(params) {
        var newMessage = new itsallagile.Model.ChatMessage(params.message);
        this.messages.add(newMessage);
        $('#chat-handle', this.$el).addClass('new-message');
    },

    /**
     * When a message is added to the collection, render the new message
     * so we don't need to rerender the whole chat box
     */
    renderNewMessage: function(message) {
        var view = new itsallagile.View.ChatMessage({model: message});
        var messageBox = $('#chat-messages', this.$el);
        messageBox.append(view.render().el);
        messageBox.prop('scrollTop', messageBox.prop('scrollHeight'));
    }
});



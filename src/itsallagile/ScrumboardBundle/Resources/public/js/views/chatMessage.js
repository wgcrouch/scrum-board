itsallagile.View.ChatMessage = Backbone.View.extend({
    tagName: 'div',
    template: '<p class="message-head"><%= user.email %>:</p><p class="message-content"><%= content %></p>',
    className: 'chat-message',
    
    
    initialize: function(options) { 
    },
    
    render: function() {
        this.$el.html(_.template(this.template, this.model.toJSON()));
        return this;
    }
});



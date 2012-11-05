/**
 * Simple view to render chat messages in the chatBox
 */
itsallagile.View.ChatMessage = Backbone.View.extend({
    tagName: 'div',
    template: '<label class="message-head" title="<%= datetime %>"><%= user.email %>:</label><p class="message-content"><%= content %></p>',
    className: 'chat-message',    
    
    initialize: function(options) { 
    },
    
    /**
     * Render a singe chat message
     */
    render: function() {
        this.$el.html(_.template(this.template, this.model.toJSON()));
        return this;
    }
});



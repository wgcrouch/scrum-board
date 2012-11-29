/**
 * Simple view to render chat messages in the chatBox
 */
itsallagile.View.ChatMessage = Backbone.View.extend({
    tagName: 'div',
    template: '<label class="message-head" title="<%= datetime %>"><%= user %>:</label><p class="message-content"><%= content %></p><hr/>',
    className: 'chat-message',

    initialize: function(options) {
    },

    /**
     * Render a singe chat message
     */
    render: function() {
        var data = this.model.toJSON();
        data.content = itsallagile.View.TextConverter.convert(data.content);
        this.$el.html(_.template(this.template, data));
        return this;
    }
});



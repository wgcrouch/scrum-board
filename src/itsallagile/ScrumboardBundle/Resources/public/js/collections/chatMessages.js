/**
 * Status Collection
 */
itsallagile.Collection.ChatMessages = Backbone.Collection.extend({
    model: itsallagile.Model.ChatMessage,
    url: '/api/chatMessages'
});

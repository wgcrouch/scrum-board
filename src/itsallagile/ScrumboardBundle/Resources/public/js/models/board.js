/**
 * Model for Boards
 */
itsallagile.Model.Board = Backbone.Model.extend({
    urlRoot: '/api/boards',

    defaults: {
        stories: null,
        chatMessages: null
    },

    initialize: function(options) {

    },

    /**
     * When we get a response from the server, that contains tickets and stories
     * Put those into collections
     */
    parse: function(response) {
        response.stories = new itsallagile.Collection.Stories(response.stories);      
        response.stories.url = this.urlRoot + '/' + response.id + '/stories';
        response.stories.forEach(function(story) {
            var tickets = story.get('tickets');
            story.set('tickets', new itsallagile.Collection.Tickets(tickets));
            story.get('tickets').url = response.stories.url + '/' + story.get('id') + '/tickets';
        });

        response.chatMessages = new itsallagile.Collection.ChatMessages(response.chatMessages);
        response.chatMessages.url = this.urlRoot + '/' + response.id + '/messages';
        return response;
    }
});


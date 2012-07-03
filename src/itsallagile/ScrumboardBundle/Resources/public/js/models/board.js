itsallagile.Model.Board = Backbone.Model.extend({
    urlRoot: '/api/boards',
    
    defaults: {
        stories: null,
        statuses: [
            'New',
            'Assigned',
            'Done'
        ]        
    },   
    
    initialize: function(options) {

    },
    
    parse: function(response) {
        response.stories = new itsallagile.Collection.Stories(response.stories);
        return response;
    }
});


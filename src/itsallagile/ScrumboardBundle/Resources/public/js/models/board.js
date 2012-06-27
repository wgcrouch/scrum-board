itsallagile.Model.Board = Backbone.Model.extend({
    urlRoot: '/boards',
    
    defaults: {
        stories: null
    },   
    
    initialize: function(options) {

    },
    
    parse: function(response) {
        response.stories = new itsallagile.Collection.Stories(response.stories);
        return response;
    }
});


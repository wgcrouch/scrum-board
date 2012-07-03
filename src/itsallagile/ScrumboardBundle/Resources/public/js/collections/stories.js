itsallagile.Collection.Stories = Backbone.Collection.extend({
    model: itsallagile.Model.Story,
    url: '/api/stories'
});

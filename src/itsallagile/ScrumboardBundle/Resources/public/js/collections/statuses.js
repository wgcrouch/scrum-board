/**
 * Status Collection
 */
itsallagile.Collection.Statuses = Backbone.Collection.extend({
    model: itsallagile.Model.Status,
    url: '/api/statuses'
});

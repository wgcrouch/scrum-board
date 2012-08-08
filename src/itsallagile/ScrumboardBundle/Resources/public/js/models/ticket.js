/**
 * Tickets Model
 */
itsallagile.Model.Ticket = Backbone.Model.extend({
    urlRoot: '/api/tickets',
    
    defaults: {
        content: ''
    }
});


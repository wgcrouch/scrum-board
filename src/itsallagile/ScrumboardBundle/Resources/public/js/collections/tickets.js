/**
 * Tickets Model
 */
itsallagile.Collection.Tickets = Backbone.Collection.extend({
    model: itsallagile.Model.Ticket,
    url: '/api/tickets'      
});


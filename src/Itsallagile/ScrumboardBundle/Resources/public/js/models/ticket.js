/**
 * Tickets Model
 */
itsallagile.Model.Ticket = Backbone.Model.extend({
    defaults: {
        content: ''
    },

    /**
     * Get the age of a ticket in days 
     */
    getAge: function() {
        var now = new Date();        
        var last = new Date(this.get("modified"));
        var age = Math.floor((now.getTime() - last.getTime()) / (1000 * 60 * 60 * 24));
        return age >= 0 ? age : 0;
    }
});


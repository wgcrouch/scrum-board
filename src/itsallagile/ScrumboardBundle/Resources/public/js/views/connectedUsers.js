/**
 * Board view
 */
itsallagile.View.ConnectedUsers = Backbone.View.extend({
    
    tagName: 'div',
    id: 'connected-users',
    template: '<ul id="users-list"></ul><p><%= connectedCount %> Connected Users</p>',
    users: [],
    events: {
        'click p' : 'toggleShowUsers'
    },
    
    /**
     * Load the fixed elements on the board
     * and do initial bindings
     */
    initialize: function(options) { 
        _.bindAll(this);
        
        return this;
    },

    /**
     * Bind to events coming in from the socket connection
     */
    bindSocketEvents: function() {
        var socket = itsallagile.socket;        
        if (typeof socket !== 'undefined') {

            socket.on('user:change', _.bind(this.onUserChange, this));
        }
    },
    
    /**
     * Render the view
     */
    render: function() {      
        this.$el.html(_.template(this.template, {connectedCount : this.users.length}));
        var list = $('ul', this.$el);
        _.forEach(this.users, function(user) {
            list.append($('<li>').html(user));
        })
        return this;
    }, 
    
        
    onUserChange: function(users) {
        this.users =_.unique(users, false);
        
        this.render();
    },
    
    toggleShowUsers: function() {
        $('#users-list', this.$el).slideToggle();
    }
        
});




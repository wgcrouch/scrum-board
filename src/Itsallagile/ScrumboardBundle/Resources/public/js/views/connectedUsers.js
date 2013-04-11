/**
 * Board view
 */
itsallagile.View.ConnectedUsers = Backbone.View.extend({

    tagName: 'div',
    id: 'connected-users',
    template: '<div id="user-handle" class="live-box-heading"><%= connectedCount %> Connected Users</div>' +
        '<ul id="users-list"></ul>',
    users: [],
    events: {
        'click #user-handle' : 'toggleShowUsers'
    },

    /**
     * Load the fixed elements on the bard
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
        });
        return this;
    },

    /**
     * When there is a change to a user from the server re render
     */
    onUserChange: function(users) {
        this.users = _.unique(users, false);

        this.render();
    },

    /**
     * Show/hide the connected users
     */
    toggleShowUsers: function() {
        $('#users-list', this.$el).slideToggle();
    }

});

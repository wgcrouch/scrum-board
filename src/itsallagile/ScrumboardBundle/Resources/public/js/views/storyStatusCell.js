/**
 * View class for a story status cell
 */
itsallagile.View.StoryStatusCell = Backbone.View.extend({
    tagName: 'td',
    className: 'story-status-cell',

    initialize: function(options) {
        this.status = options.status;
        this.story = options.story;
        this.tickets = options.tickets;
        this.tickets.bind('add', this.render, this);
        this.tickets.bind('remove', this.render, this);
        this.tickets.bind('change', this.render, this);
        this.tickets.bind('reset', this.render, this);
    },

    events: {
      "drop": "drop"
    },

    /**
     * Render the status cell and make it a droppable and create an render the ticket views
     */
    render: function() {
        this.$el.html('');
        this.$el.addClass('story-status-' + this.status.get("id"));
        this.$el.droppable({
            hoverClass: 'drop-hover',
            activeClass: 'drop-active'
        });

        this.tickets.forEach(function(ticket) {
            var ticketView = new itsallagile.View.Ticket({model: ticket});
            this.$el.append(ticketView.render().el);
        }, this);

        return this;
    },

    /**
     * Handle drop events for templates or tickets
     */
    drop: function(event, ui) {

        if (ui.draggable.hasClass('template')) {
            var type = ui.helper.data('type');
            this.createTicket(type);
            return;
        }

        //If we are moving ticket find out the details and
        //fire an event to handle the change at the story level
        if (ui.draggable.hasClass('ticket')) {
            var storyId = ui.draggable.data('story');
            var status = ui.draggable.data('status');
            var ticketId = ui.draggable.data('ticketId');
            //if nothing has changed then do nothing
            if (storyId == this.story.get('id') &&  status == this.status.get('id')) {
                return false;
            }
            ui.draggable.remove();
            event.stopPropagation();

            this.trigger('moveTicket', ticketId, storyId, this.status.get('id'));
        }
        return;
    },

    /**
     * Event handler for creating a ticket from a template
     */
    createTicket: function(type) {
        var data = {
            status: this.status.get('id'),
            type: type,
            story: this.story.get('id')
        }
        var ticket = new itsallagile.Model.Ticket(data);

        this.story.get('tickets').add(ticket, {silent: true});
        ticket.save(null, {success: this.onCreateSuccess, silent:true});
        this.addTicket(ticket);
    },

    /**
     * Fire a remote event when the ticket is created successfully
     */
    onCreateSuccess: function(model, response) {
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('boardEvent', itsallagile.roomId, 'ticket:create', response);
        }
    },

    /**
     * Add a ticket to this status cell
     */
    addTicket: function(ticket) {
        this.tickets.add(ticket, {silent:true});
        var ticketView = new itsallagile.View.Ticket({model: ticket});
        this.$el.append(ticketView.render().el);
    },

    /**
     * Remove a ticket from this status cell
     */
    removeTicket: function(ticket) {
        this.tickets.remove(ticket);
    }

});
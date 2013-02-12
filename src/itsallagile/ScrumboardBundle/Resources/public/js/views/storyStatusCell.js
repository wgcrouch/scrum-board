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
        this.tickets.bind('add', this.renderTicket, this);
        this.tickets.bind('remove', this.render, this);
        _.bindAll(this);
    },

    events: {
      "drop": "drop"
    },

    /**
     * Render the status cell and make it a droppable and create an render the ticket views
     */
    render: function() {
        this.$el.html('');
        this.$el.addClass('story-status-' + this.status.id);
        this.$el.droppable({
            hoverClass: 'drop-hover',
            activeClass: 'drop-active',
            accept: '.ticket'
        });

        this.tickets.forEach(function(ticket) {
            this.renderTicket(ticket);
        }, this);

        return this;
    },

    /**
     * Handle drop events for templates or tickets
     */
    drop: function(event, ui) {

        //If this is a new ticket create it
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
            if (storyId == this.story.get('id') &&  status == this.status.id) {
                return false;
            }
            ui.draggable.remove();
            event.stopPropagation();

            this.trigger('moveTicket', ticketId, storyId, this.status.id);
        }
        return;
    },

    /**
     * Event handler for creating a ticket from a template
     */
    createTicket: function(type) {
        var ticketData = {
            status: this.status.id,
            type: type
        }

        var tickets = this.story.get('tickets');        
        var newTicket = tickets.create(
            ticketData,
            {success: this.onCreateSuccess}
        );
    },

    /**
     * Fire a remote event when the ticket is created successfully
     */
    onCreateSuccess: function(model, response) {
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit(
                'boardEvent', 
                itsallagile.roomId, 
                'ticket:create', 
                {ticket: response, storyId: this.story.get('id')}
            );
        }
    },

    /**
     * Add a ticket to this status cell
     */
    addTicket: function(ticket) {
        this.tickets.add(ticket, {silent:true});
        this.renderTicket(ticket);
    },
    
    renderTicket: function(ticket) {
        var ticketView = new itsallagile.View.Ticket({model: ticket, story: this.story});
        this.$el.append(ticketView.render().el);
    },

    /**
     * Remove a ticket from this status cell
     */
    removeTicket: function(ticket) {
        this.tickets.remove(ticket);
    }

});
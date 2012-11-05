//View class for the story row
itsallagile.View.Story = Backbone.View.extend({
    tagName: 'tr',
    id: 'story',
    className: 'story',
    
    template: '<td class="story-detail-cell">' +
        '<div class="notepaper">' +
        '<p class="story-content"><%= content %></p><textarea class="story-input"><%= content %></textarea>' +
        '<div class="story-points"><p><%= points %></p><textarea class="story-points-input"><%= points %></textarea></div>' +
        '<i class="icon-remove delete-story"></i></td>' +
        '</div>',
    
    statuses: null,
    
    events: {
        "dblclick .story-content": "startEditContent",
        "blur .story-input": "endEditContent",
        "click .story-points": "startEditPoints",
        "blur .story-points-input": "endEditPoints",
        'hover .story-detail-cell' : 'toggleShowDelete',
        'mouseOut .story-detail-cell' : 'toggleShowDelete',
        'click .delete-story' : 'deleteConfirm'
    },

    //Set up the statuses and bind on changes to models
    initialize: function(options) {
        this.statuses = options.statuses;
        this.model.bind('change', this.render, this);
        this.model.get('tickets').bind('add', this.addTicket, this);
        this.model.get('tickets').bind('remove', this.removeTicket, this);
        _.bindAll(this);
    },

    /**
     * Render the story row and create and render views for each status cell
     */
    render: function() {
        this.id = this.model.get('id');
        this.$el.attr('id', 'story' + '-' + this.id);
        this.$el.html(_.template(
            this.template, {content : this.model.get("content"), points: this.model.get("points")}));
        var contentP = $('p.story-content', this.$el);

        contentP.html(this.formatText(contentP.html()));
        
        this.statusViews = {};
        this.statuses.forEach(function(status, key) {
            var statusTickets = new itsallagile.Collection.Tickets();
            var statusView = new itsallagile.View.StoryStatusCell(
                {status: status, story: this.model, tickets: statusTickets});
                
            statusView.on('moveTicket', this.onMoveTicket, this);
            this.statusViews[status.get('id')] = statusView;
            this.$el.append(statusView.render().el);  
        }, this);

        //Assign tickets to the appropriate status view
        var tickets = this.model.get('tickets');        
        tickets.forEach(function(ticket) {
            var status = ticket.get('status');
            if (typeof status !== 'undefined') {
                this.statusViews[status].addTicket(ticket);
            }
        }, this);               
        
        return this;    
    },

    /**
     * Event handler for moving a ticket
     */
    onMoveTicket: function(ticketId, originStoryId, status) {
        //If this ticket is not from this story, then fire an event
        //We need to handle it at the board level
        if (this.model.get('id') !== originStoryId) {
            this.trigger('moveTicket', ticketId, originStoryId, status, this.model.get('id'));
            return;
        }

        var ticket = this.model.get('tickets').get(ticketId);
        this.statusViews[ticket.get('status')].tickets.remove(ticket, {silent:true});
        ticket.save(
            {story: this.model.get('id'), status: status},
            {silent:true});
        this.statusViews[status].addTicket(ticket);    
        
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('boardEvent', itsallagile.roomId, 'ticket:move', 
                {ticket: ticket, originStoryId: originStoryId});
        }        
    },

    /**
     * Show the edit box when story content is double clicked
     */
    startEditContent: function() {
        $('p.story-content',this.$el).hide();
        $('textarea.story-input', this.$el).show().focus();
    },

    /**
     * Save the story when editing content has finished
     */    
    endEditContent: function() {
        var p = $('p.story-content',this.$el);
        var text = $('textarea.story-input', this.$el);
        p.html(this.formatText(text.val()));
        text.hide();
        p.show();        
        this.model.save({'content': text.val()}, {silent: true});
    },

    /**
     * Show the edit box when story content is double clicked
     */
    startEditPoints: function() {
        $('.story-points p',this.$el).hide();
        $('.story-points-input', this.$el).show().focus();
    },

    /**
     * Save the story when editing content has finished
     */
    endEditPoints: function() {
        var p = $('.story-points p',this.$el);
        var text = $('.story-points-input', this.$el);
        p.html(text.val());
        text.hide();
        p.show();
        this.model.save({'points': text.val()}, {silent:true});
    },

    /**
     * Show/hide the delete icon
     */
    toggleShowDelete: function() {
        $('.delete-story', this.$el).fadeToggle('fast');
    },

    /**
     * Show a confirmation dialog when trying to delete a story
     */
    deleteConfirm: function(event) {
        if (confirm('Are you sure you want to delete this story?')) {
            this.model.destroy({silent: true});
            this.$el.fadeOut();
            var notification = new itsallagile.View.Notification({
                message: 'Story deleted successfully',
                type: 'success'
            });
            notification.render();
        } else {
            event.preventDefault();
            event.stopPropagation();
        }
    },

    /**
     * Hacky formatting for text in stories, currently only does nl2br
     */
    formatText: function(text) {
        var breakTag = '<br/>';
        return (text + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    },
    
    /**
     * Add a ticket to this story and make sure the status view also gets it
     */
    addTicket: function(ticket) {
        this.statusViews[ticket.get('status')].addTicket(ticket);
    },
    
    /**
     * Remove a ticket from this story and the approriate status view
     */
    removeTicket: function(ticket) {
        this.statusViews[ticket.get('status')].removeTicket(ticket);
    }
});
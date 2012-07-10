//View class for the story row
itsallagile.View.Story = Backbone.View.extend({
    tagName: 'tr',
    id: 'story',
    className: 'story',
    template: '<td class="story-detail-cell">' + 
        '<p class="story-content"><%= content %></p><textarea class="story-input"><%= content %></textarea>' + 
        '<div class="story-points"><p><%= points %></p><textarea class="story-points-input"><%= points %></textarea></div>' +
        '<i class="icon-remove delete-story"></i></td>',
    statuses: null,
    statusViews: [],
    
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
    },
    
    //Render function
    //Renders the status cells and tickets within those cells
    render: function() {
        this.model.bind('change', this.render, this);
        this.model.get('tickets').bind('add', this.render, this);
        this.model.get('tickets').bind('remove', this.render, this);
        this.model.get('tickets').bind('change', this.render, this);
        this.model.get('tickets').bind('reset', this.render, this);
        this.id = this.model.get('id');
        this.$el.html(_.template(
            this.template, {content : this.model.get("content"), points: this.model.get("points")}));
        

        this.statuses.forEach(function(status, key) {
            var statusView = new itsallagile.View.StoryStatusCell({status: status, story: this.model});          
            statusView.on('moveTicket', this.onMoveTicket, this);
            statusView.on('createTicket', this.onCreateTicket, this);
            
            this.$el.append(statusView.render().el);
            this.statusViews[status.get('id')] = statusView;
        }, this);
        
        var tickets = this.model.get('tickets');
       
        tickets.forEach(function(ticket) {
            var status = ticket.get('status');
            if (typeof status !== 'undefined') {
                var ticketView = new itsallagile.View.Ticket({model: ticket});
                this.statusViews[status].$el.append(ticketView.render().el);
            }
        }, this);
              
        return this;
    },
    
    //Event handler for moving a ticket
    onMoveTicket: function(ticketCid, originStoryId, status) {
        if (this.model.get('id') !== originStoryId) {
            this.trigger('moveTicket', ticketCid, originStoryId, status, this.model.get('id'));
            return
        }
        
        var ticket = this.model.get('tickets').getByCid(ticketCid);
        ticket.set('story', this.model.get('id'));
        ticket.set('status', status);
        ticket.save();
    },
    
    //Event handler for creating a ticket from a template
    onCreateTicket: function(status, type) {
        var data = {
            status: status,
            type: type,
            story: this.model.get('id')
        }

        var ticket = new itsallagile.Model.Ticket(data);
        var tickets = this.model.get('tickets');
        tickets.add(ticket);
        ticket.save();
    },
    
    //Show the edit box when story content is double clicked
    startEditContent: function() {
        $('p.story-content',this.$el).hide();
        $('textarea.story-input', this.$el).show().focus();
    },
    
    //Save the story when editing content has finished
    endEditContent: function() {
        var p = $('p.story-content',this.$el);
        var text = $('textarea.story-input', this.$el);
        p.html(text.val());
        text.hide();
        p.show();
        this.model.set('content', text.val());
        this.model.save();
    },
    
    //Show the edit box when story content is double clicked
    startEditPoints: function() {
        $('.story-points p',this.$el).hide();
        $('.story-points-input', this.$el).show().focus();
    },
    
    //Save the story when editing content has finished
    endEditPoints: function() {
        var p = $('.story-points p',this.$el);
        var text = $('.story-points-input', this.$el);
        p.html(text.val());
        text.hide();
        p.show();
        this.model.set('points', text.val());
        this.model.save();
    },
    
    toggleShowDelete: function() {
        $('.delete-story', this.$el).fadeToggle('fast');
    },
    
    deleteConfirm: function(event) {
        if (confirm('Are you sure you want to delete this story?')) {
            this.model.destroy({silent: true});
            this.$el.fadeOut();
        } else {
            event.preventDefault();
            event.stopPropagation();
        }
    }
});





//View class for the story row
itsallagile.View.Story = Backbone.View.extend({
    tagName: 'div',
    id: 'story',
    className: 'story',
    template: '<div class="story-detail-cell"><p class="story-content"><%= content %></p><p class="story-input"><%= content %></p></div>',
    statuses: null,
    statusViews: [],
    
    //Set up the statuses and bind on changes to models
    initialize: function(options) {
        this.statuses = options.statuses;
        this.model.bind('change', this.render, this);
        this.model.get('tickets').bind('add', this.render, this);
        this.model.get('tickets').bind('remove', this.render, this);
        this.model.get('tickets').bind('change', this.render, this);
    },
    
    //Render function
    //Renders the status cells and tickets within those cells
    render: function() {
        this.id = this.model.get('id');
        this.$el.html(_.template(this.template, {content : this.model.get("content")}));
        

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
            var ticketView = new itsallagile.View.Ticket({model: ticket});
            this.statusViews[status].$el.append(ticketView.render().el);
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
    }
});





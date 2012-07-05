itsallagile.View.Story = Backbone.View.extend({
    tagName: 'div',
    id: 'story',
    className: 'story',
    template: '<div class="story-detail-cell"><p class="story-content"><%= content %></p><p class="story-input"><%= content %></p></div>',
    statuses: null,
    statusViews: [],
    
    initialize: function(options) {
        this.statuses = options.statuses;
        this.model.bind('change', this.render, this);
    },
    
    render: function() {
        this.id = this.model.get('id');
        this.$el.html(_.template(this.template, {content : this.model.get("content")}));
        

        this.statuses.forEach(function(status, key) {
            this.statusViews[status.get('id')] = new itsallagile.View.StoryStatusCell({status: status});
            this.$el.append(this.statusViews[status.get('id')].render().el);
        }, this);
        
        var tickets = this.model.get('tickets');
       
        tickets.forEach(function(ticket) {
            var status = ticket.get('status');
            var ticketView = new itsallagile.View.Ticket({model: ticket});
            this.statusViews[status].$el.append(ticketView.render().el);
        }, this);
        
        
        return this;
    }
});





itsallagile.View.StoryStatusCell = Backbone.View.extend({
    tagName: 'div',
    className: 'story-status-cell',
    status: null,    
    storyView: null,
    
    initialize: function(options) {
        this.status = options.status;
        this.storyView = options.storyView;
    },    
    events: {
      "drop": "drop"    
    },
    render: function() {      
        this.$el.addClass('story-status-' + this.status.get("id"));
        this.$el.droppable({
            hoverClass: 'drop-hover',
            activeClass: 'drop-active'
        });
        
        return this;
    },  
    
    drop: function(event, ui) {
        var type = ui.helper.data('type');
        var data = {
            status: this.status.get('id'),
            type: type,
            story: this.storyView.model.get('id')
        }

        var ticket = new itsallagile.Model.Ticket(data);
        var tickets = this.storyView.model.get('tickets');
        tickets.add(ticket);
        ticket.save();
    }
    
});





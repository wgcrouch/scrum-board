/**
 * View class for a story status cell
 */
itsallagile.View.StoryStatusCell = Backbone.View.extend({
    tagName: 'td',
    className: 'story-status-cell',
    status: null,    
    story: null,
    
    //Set the values passed in
    initialize: function(options) {
        this.status = options.status;
        this.story = options.story;
    },    
    
    //Bind events to methods
    events: {
      "drop": "drop"    
    },
    
    //Render the status cell and make it a droppable
    render: function() {      
        this.$el.addClass('story-status-' + this.status.get("id"));
        this.$el.droppable({
            hoverClass: 'drop-hover',
            activeClass: 'drop-active'
        });
        
        return this;
    },  
    
    //Handle drop events for templates or tickets
    drop: function(event, ui) {
        
        if (ui.draggable.hasClass('template')) {
            var type = ui.helper.data('type');
            this.trigger('createTicket',this.status.get('id'), type);
            return;
        }
        
        if (ui.draggable.hasClass('ticket')) {
            var storyId = ui.draggable.data('story');
            var status = ui.draggable.data('status');
            var cid = ui.draggable.data('cid');
            //if nothing has changed then do nothing
            if (storyId == this.story.get('id') &&  status == this.status.get('id')) {
                return false;
            }
            ui.draggable.remove();
            event.stopPropagation();
            this.trigger('moveTicket', cid, storyId, this.status.get('id'));
        }
        return;
    }
    
});





/**
 * Board view
 */
itsallagile.View.Board = Backbone.View.extend({
    tagName: 'table',
    className: 'board',
    statuses: [],
    statusHeaderView: null,
    storyViews: {},
    
    
    /**
     * Load the fixed elements on the board
     * and do initial bindings
     */
    initialize: function(options) { 
        this.statuses = options.statuses;
        this.statusHeaderView = new itsallagile.View.StatusHeader({statuses : this.statuses});
        this.model.bind('change', this.render, this);

        return this;
    },
    
    /**
     * Render the board by rendering its toolbar and header
     * and calling render on all stories
     */
    render: function() {      
        
        this.$el.append(this.statusHeaderView.render().el);
        var stories = this.model.get('stories');
        if (stories !== null) {
            stories.forEach(function(story, key) {
                var storyView = new itsallagile.View.Story({model: story, statuses: this.statuses});
                storyView.on('moveTicket', this.onMoveTicket, this);
                this.storyViews[story.get('id')] = storyView;
                this.$el.append(storyView.render().el);
            }, this);
        }
        
        return this;
    }, 
    
    //Handle moving a ticket between stories
    //Looks at bit hacky, but I couldnt find an easier way
    //of moving an object between collections
    onMoveTicket: function(ticketCid, originStoryId, status, newStoryId) {
        var stories = this.model.get('stories');
        var originStory = stories.get(originStoryId);
        var newStory = stories.get(newStoryId);
        var oldTicket = originStory.get('tickets').getByCid(ticketCid);
        var newTicket = new itsallagile.Model.Ticket(oldTicket.toJSON());
        
        newTicket.set('story', newStoryId);
        newTicket.set('status', status);
        newTicket.save();
        newStory.get('tickets').add(newTicket);
        originStory.get('tickets').remove(oldTicket);
       
    }
    
});




/**
 * Board view
 */
itsallagile.View.Board = Backbone.View.extend({
    tagName: 'div',
    className: 'board',
    toolbarView: null,
    statuses: [],
    statusHeaderView: null,
    storyViews: {},
    
    
    /**
     * Load the fixed elements on the board
     * and do initial bindings
     */
    initialize: function(options) {
        // Currently templates cannot be customized, so hard code them in
        // and pass them into a new Toolbar view
        this.toolbarView = new itsallagile.View.Toolbar({
            templates: [
                new itsallagile.View.Template({type: 'task'}),
                new itsallagile.View.Template({type: 'test'}),
                new itsallagile.View.Template({type: 'bug'}),
                new itsallagile.View.Template({type: 'defect'}),
                new itsallagile.View.Template({type: 'design'}),
            ]
        });  
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
        this.$el.html('');
        this.$el.append(this.toolbarView.render().el);
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




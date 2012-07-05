/**
 * Board view
 */
itsallagile.View.Board = Backbone.View.extend({
    tagName: 'div',
    className: 'board',
    toolbarView: null,
    statuses: [],
    statusHeaderView: null,
    
    
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
                this.$el.append(storyView.render().el);
            }, this);
        }
        
        return this;
    }
    
});




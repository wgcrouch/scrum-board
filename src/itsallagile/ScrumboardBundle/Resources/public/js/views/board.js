itsallagile.View.Board = Backbone.View.extend({
    tagName: 'div',
    className: 'board',
    toolbarView: null,
    
    initialize: function(options) {
        this.toolbarView = new itsallagile.View.Toolbar({
            templates: [
                new itsallagile.View.Template({type: 'task'}),
                new itsallagile.View.Template({type: 'test'}),
                new itsallagile.View.Template({type: 'bug'}),
                new itsallagile.View.Template({type: 'defect'}),
                new itsallagile.View.Template({type: 'design'}),
            ]
        });
        this.model.bind('change', this.render, this);
        return this;
    },
    
    render: function() {
        this.$el.append(this.toolbarView.render().el);
        
        var stories = this.model.get('stories');
        if (stories !== null) {
            stories.forEach(function(story, key) {
                var storyView = new itsallagile.View.Story({model: story});
                this.$el.append(storyView.render().el);
            }, this);
        }
        
        return this;
    }
    
});




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
    },
    
    render: function() {
        this.$el.append(this.toolbarView.render().el);
        return this;
    }
    
});




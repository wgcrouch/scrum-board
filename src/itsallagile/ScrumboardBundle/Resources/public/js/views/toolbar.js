itsallagile.View.Toolbar = Backbone.View.extend({
    tagName: 'div',
    id: 'templates',
    templates: [],
    
    initialize: function(options) {
        this.templates = options.templates;
    },
    
    render: function() {
        _.forEach(this.templates, function(template, key) {
            console.log(template);
            this.$el.append(template.render().el);
        }, this);
        return this;
    }
});



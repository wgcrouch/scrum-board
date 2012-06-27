itsallagile.View.Template = Backbone.View.extend({
    tagName: 'div',
    templates: [],
    className: 'template',
    type: null,
    
    initialize: function(options) {
        this.id = 'template-' + options.type;
        this.type = options.type;
    },
    
    render: function() {
        this.$el.addClass(this.type);
        
        
        return this;
    }
});



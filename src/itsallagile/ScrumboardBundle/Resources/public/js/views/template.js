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
        this.$el.draggable({
            opacity: 0.7,
            helper: "clone"            
        });
        this.$el.attr('data-type', this.type);
        
        return this;
    }
});



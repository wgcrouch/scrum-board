itsallagile.View.StoryStatusCell = Backbone.View.extend({
    tagName: 'div',
    className: 'story-status-cell',
    status: null,    
    initialize: function(options) {
        this.status = options.status;
    },    
    render: function() {      
        this.$el.addClass('story-status-' + this.status.get("id"));
                
        return this;
    }
});





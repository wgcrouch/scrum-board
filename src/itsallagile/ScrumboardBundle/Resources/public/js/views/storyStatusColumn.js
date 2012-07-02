itsallagile.View.StoryStatusColumn = Backbone.View.extend({
    tagName: 'div',
    className: 'story-status-column',
    status: null,
    initialize: function(options) {
        this.status = options.status;
    },    
    render: function() {
        this.$el.addClass('story-status-' + this.status);
        
        return this;
    }
});





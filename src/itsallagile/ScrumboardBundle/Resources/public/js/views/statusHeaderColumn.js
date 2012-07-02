itsallagile.View.StatusHeaderColumn = Backbone.View.extend({
    tagName: 'div',
    className: 'status-header-column',
    status: null,
    initialize: function(options) {
        this.id = 'status-header' + options.status;
        this.status = options.status;
    },    
    render: function() {
        this.$el.addClass('status-header-' + this.status).html(this.status);
        return this;
    }
});





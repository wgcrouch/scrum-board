/**
 * View for the status header cells
 */
itsallagile.View.StatusHeaderCell = Backbone.View.extend({
    tagName: 'td',
    className: 'status-header-cell',
    status: null,
    initialize: function(options) {
        this.id = 'status-header' + options.status;
        this.status = options.status;
    },    
    render: function() {
        this.$el.addClass('status-header-' + this.status.get('id')).html(this.status.get('name'));
        return this;
    }
});
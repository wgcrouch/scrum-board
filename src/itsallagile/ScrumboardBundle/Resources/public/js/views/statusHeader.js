/**
 * View for the status header
 * 
 * Container div for the status column headers
 */
itsallagile.View.StatusHeader = Backbone.View.extend({
    tagName: 'tr',
    id: 'status-header',
    className: 'status-header',
    cellTemplates: [],
    
    /**
     * When passed a list of statuses create header templates for each one
     */
    initialize: function(options) {
        this.cellTemplates.push(new itsallagile.View.StatusHeaderCell({status: new itsallagile.Model.Status({name:'Story'})}));
        options.statuses.forEach(function(status, key) {
            this.cellTemplates.push(new itsallagile.View.StatusHeaderCell({status: status}));
        }, this);        
    },
    
    /**
     * Render the header cells
     */
    render: function() {
        _.forEach(this.cellTemplates, function(template, key) {
            this.$el.append(template.render().el);
        }, this);
        return this;
    }
});



itsallagile.View.StatusHeader = Backbone.View.extend({
    tagName: 'div',
    id: 'status-header',
    className: 'status-header',
    templates: [],
    initialize: function(options) {
        this.templates.push(new itsallagile.View.StatusHeaderColumn({status: 'Story'}));
        _.forEach(options.statuses, function(status, key) {
            this.templates.push(new itsallagile.View.StatusHeaderColumn({status: status}));
        }, this);
        
    },
    
    render: function() {
        _.forEach(this.templates, function(template, key) {
            this.$el.append(template.render().el);
        }, this);
        return this;
    }
});



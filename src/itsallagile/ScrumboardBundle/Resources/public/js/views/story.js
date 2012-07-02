itsallagile.View.Story = Backbone.View.extend({
    tagName: 'div',
    id: 'story',
    className: 'story',
    template: '<div class="story-detail-column"><p class="story-content"><%= content %></p><p class="story-input"><%= content %></p></div>',
    statuses: null,
    
    initialize: function(options) {
        this.statuses = options.statuses;
    },
    
    render: function() {
        this.id = this.model.get('id');
        this.$el.append(_.template(this.template, {content : this.model.get("content")}));
        this.$el.append();
        if (this.statuses !== null) {
            this.statuses.forEach(function(status, key) {
                var statusView = new itsallagile.View.StoryStatusColumn({status: status});
                this.$el.append(statusView.render().el);
            }, this);
        }
        return this;
    }
});





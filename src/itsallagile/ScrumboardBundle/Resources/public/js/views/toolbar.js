itsallagile.View.Toolbar = Backbone.View.extend({
    tagName: 'div',
    id: 'toolbar',
    templates: [],
    template: "<div id='templates'></div><div id='actions'><div id='addStory' class='action'>New Story</div></div>",
    
    events: {
        'click #addStory' : 'onClickAddStory'
    },
    
    initialize: function(options) {
        this.templates = options.templates;
    },
    
    render: function() {
        this.$el.append(_.template(this.template));
        var templateContainer = $('#templates', this.$el);
        _.forEach(this.templates, function(template, key) {
            templateContainer.append(template.render().el);
        }, this);
        return this;
    },
    
    onClickAddStory: function() {
        var story = new itsallagile.Model.Story({boardId: this.model.get('id')});
        story.save();
        this.model.get('stories').add(story);
    }
});



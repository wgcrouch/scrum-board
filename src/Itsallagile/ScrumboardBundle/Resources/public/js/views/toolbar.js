/**
 * View for the side toolbar
 */
itsallagile.View.Toolbar = Backbone.View.extend({
    tagName: 'div',
    id: 'toolbar',
    templates: [],
    template: "<button id='addStory' class='btn'>New Story</button><ul id='templates'></ul>",
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

    /**
     * Event handler for the new story button
     */
    onClickAddStory: function() {
        var stories = this.model.get('stories');
        
        var newStory = stories.create(
            {}, 
            {
                wait: true, 
                success: function(story) {    
                    story.get('tickets').url = story.url() + '/tickets';
                    if (typeof itsallagile.socket !== 'undefined') {
                        itsallagile.socket.emit('boardEvent', itsallagile.roomId, 'story:add', story);
                    }
                }
            }
        );        
       
    }
});



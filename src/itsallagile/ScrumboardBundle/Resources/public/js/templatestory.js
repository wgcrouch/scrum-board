/**
 * Story Template object, stories are created from story templates
 */
itsallagile.storytemplate = itsallagile.template.extend({
    board:null,
    
    /**
     * Render a template in a container
     */
    render: function(container) {
        var div = $('<div>').attr('id', 'storytemplate')
            .addClass('storytemplate').addClass(this.type);
        container.prepend(div);
        this.init();
    },
    
    init: function() {
        //Store this as self, for use inside callbacks
        var self = this;
        $('#storytemplate').draggable({
            containment: itsallagile.board.getCssId(),
            opacity: 0.7,
            helper: "clone",
            //Using an anonymous function here allows us to call the method 
            //on this object so that "this" becomes the object instead of 
            //the dom element
            stop: function(event, ui) {
                self.handleDrop(event, ui);
            }
        });
    },
    
    handleDrop: function(event, ui) {  
        var story = itsallagile.story.createFromDroppedTemplate(this, event, ui);
        story.create();
        story.render(itsallagile.board.getElement());
        this.board.addStory(story);
    }
});
/**
 * TIcket object
 */
itsallagile.story = itsallagile.baseObject.extend({
    id: null,
    content: 'New Story',
    
    x: 10,
    y: 10,
    boardId: null,
    
    /**
     * Given a template object, create a new story object
     */
    createFromDroppedTemplate: function(template, event, ui) {
        var newStory = this.extend();
        newStory.x = ui.position.left;
        newStory.y = ui.position.top;
        newStory.id = new Date().getTime();
        newStory.boardId = itsallagile.board.id;
        return newStory;
    },
    
    init: function() {
        var self = this;
        var element = this.getElement();

        element.draggable({ 
            containment: itsallagile.board.getCssId(), 
            stack: '#board div',
            stop: function(event, ui) {
                self.handleDrop(event, ui);
            } 
        });
        element.resizable();
        
        element.dblclick(function() {
            var textarea = $(this).children('textarea');
            var content = $(this).children('p');
            content.hide();
            textarea.show();
            textarea.focus();
        });
        
        var textarea = $(this.getCssId() + ' textarea');            
        textarea.blur(function() {
            var textarea = $(this);
            var content = $(this).siblings('p');
            self.content = textarea.val();
            content.html(self.content);
            textarea.hide();
            content.show();
            self.update();
        });
    },
    
    handleDrop: function(event, ui) {
        this.x = ui.position.left;
        this.y = ui.position.top;
        this.update();
    },

    /**
     * Render a ticket in a container
     */
    render: function(container) {
        var div = $('<div>').attr('id', 'story-' + this.id)
            .addClass('note').addClass('story');
        var p = $('<p>').addClass('note-content').html(this.content);
        var text = $('<textarea>').addClass('note-input').html(this.content);        
        div.append(p).append(text);
        div.css('left', this.x);
        div.css('top', this.y);
        div.data('id', this.id);
        
        container.append(div);

        this.init();
    },
    
    /**
     * Update a ticket by making a xhr request to the rest api
     */
    update: function()
    {
        var self = this;
        var data = this.getSimple();        
        $.ajax({
            type: 'PUT',
            url: '/stories/' + this.id,
            data: data,
            success: function(data, textStatus, jqXHR) {},
            dataType: 'json'
        });
    },
    
    erase: function()
    {
        var self = this;     
        $.ajax({
            type: 'DELETE',
            url: '/stories/' + this.id,
            success: function(data, textStatus, jqXHR) {},
            dataType: 'json'
        });
    },
    
    /**
     * Create the ticket on the server by posting to the REST API
     */
    create: function()
    {        
        var self = this;
        var data = this.getSimple();
        $.post('/stories', data, function(data, textStatus, jqXHR) {
            
            $(self.getCssId()).attr('id', 'ticket-' + data.id).data('id', data.id);
            delete itsallagile.board.stories[this.id];
            self.id = data.id;                      
            itsallagile.board.addStory(self);
        }, 'json');
        
    },
    
    getElement: function()
    {
        return $(this.getCssId());
    },
    
    getCssId: function()
    {
        return '#story-' + this.id;
    },
  
    /**
     * Join a ticket onto another ticket
     */
    join: function(parent) {
    }

});

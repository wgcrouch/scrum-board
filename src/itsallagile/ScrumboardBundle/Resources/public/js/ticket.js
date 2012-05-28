/**
 * TIcket object
 */
itsallagile.ticket = itsallagile.baseObject.extend({
    id: null,
    type: null,
    content: 'New Ticket',
    x: 10,
    y: 10,
    parent: null,
    
    /**
     * Given a template object, create a new ticket object with the templates type
     */
    createFromDroppedTemplate: function(template, event, ui) {
        var newTicket = this.extend({type:  template.type});
        newTicket.x = ui.position.left;
        newTicket.y = ui.position.top;
        newTicket.id = new Date().getTime();
        return newTicket;
    },
    
    init: function() {
        var self = this;
        var element = this.getElement();

        element.draggable({ 
            containment: "#board", 
            stack: '#board div',
            stop: function(event, ui) {
                self.handleDrop(event, ui);
            } 
        });
        element.resizable();
        
        element.dblclick(function() {
            var note =  $(this);
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
        var div = $('<div>').attr('id', 'ticket-' + this.id)
            .addClass('note').addClass(this.type);
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
            url: '/ticket/' + this.id,
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
            url: '/ticket/' + this.id,
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
        $.post('/ticket', data, function(data, textStatus, jqXHR) {
            
            $(self.getCssId()).attr('id', 'ticket-' + data.id).data('id', data.id);
            delete itsallagile.board.tickets[this.id];
            self.id = data.id;                      
            itsallagile.board.addTicket(self);
        }, 'json');
        
    },
    
    getElement: function()
    {
        return $(this.getCssId());
    },
    
    getCssId: function()
    {
        return '#ticket-' + this.id;
    },
  
    /**
     * Join a ticket onto another ticket
     */
    join: function(parent) {
    }

});

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
    boardId: null,
    
    /**
     * Given a template object, create a new ticket object with the templates type
     */
    createFromDroppedTemplate: function(template, event, ui) {
        var newTicket = this.extend({type:  template.type});
        newTicket.x = ui.position.left;
        newTicket.y = ui.position.top;
        newTicket.id = new Date().getTime();
        newTicket.boardId = itsallagile.board.id;
        return newTicket;
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
        var div = $('<div>').attr('id', 'ticket-' + this.id)
            .addClass('note').addClass(this.type);
        var p = $('<p>').addClass('note-content').html(this.content);
        var text = $('<textarea>').addClass('note-input').html(this.content);        
        div.append(p).append(text);
        div.css('left', this.x);
        div.css('top', this.y);
        div.data('id', this.id);
        
        container.append(div);

        div.animate({
            left: this.x,
            top: this.y
        }, 500);
        
        this.init();
    },
    
    refresh: function()
    {
        var element = this.getElement();
        
        element.animate({
            left: this.x,
            top: this.y
        }, 500);
        
        $('p', element).html(this.content);
        $('textarea', element).html(this.content);
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
            url: '/tickets/' + this.id,
            data: data,
            success: function(data, textStatus, jqXHR) {
                itsallagile.socket.emit('ticket:change', itsallagile.board.getRoomId(), data);
            },
            dataType: 'json'
        });
    },
    
    erase: function()
    {
        var self = this;     
        $.ajax({
            type: 'DELETE',
            url: '/tickets/' + this.id,
            success: function(data, textStatus, jqXHR) {
                itsallagile.socket.emit('ticket:delete',itsallagile.board.getRoomId(), self.id);
            },
            dataType: 'json'
        });
    },
        
    set: function(data) {
        for (prop in data) {
            this[prop] = data[prop];
        }
    },
    
    /**
     * Create the ticket on the server by posting to the REST API
     */
    create: function()
    {        
        var self = this;
        var data = this.getSimple();
        $.post('/tickets', data, function(data, textStatus, jqXHR) {
            
            $(self.getCssId()).attr('id', 'ticket-' + data.id).data('id', data.id);
            delete itsallagile.board.tickets[this.id];
            self.id = data.id;                      
            itsallagile.board.addTicket(self);
            itsallagile.socket.emit('ticket:create', itsallagile.board.getRoomId(), data);
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

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
        newTicket.x = ui.offset.left;
        newTicket.y = ui.offset.top;
        newTicket.id = 'ticket' + new Date().getTime();
        return newTicket;
    },
    
    init: function() {
        $('#' + this.id).draggable({ 
            containment: "#board", 
            stack: '#board div',
            stop: this.handleDrop
        });
        $('#' + this.id).resizable();
    },
    
    handleDrop: function(event, ui) {
        
    },

    /**
     * Render a ticket in a container
     */
    render: function(container) {
        var div = $('<div>').attr('id', this.id)
            .addClass('note').addClass(this.type);
        var p = $('<p>').addClass('note-content');
        var text = $('<textarea>').addClass('note-input');        
        div.append(p).append(text);
        div.css('left', this.x);
        div.css('top', this.y);
        
        container.append(div);
        div.offset({left: this.x, top: this.y});
        this.init();
    },
    
    /**
     * Update a ticket by making a xhr request to the rest api
     */
    update: function()
    {
    },

    /**
     * Join a ticket onto another ticket
     */
    join: function(parent) {
    }
});

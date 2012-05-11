/**
 * Template object, tickets are created from templates
 */
itsallagile.template = itsallagile.baseObject.extend({
    type: null,
    board:null,
    
    /**
     * Render a template in a container
     */
    render: function(container) {
        var div = $('<div>').attr('id', 'template-' + this.type)
            .addClass('template').addClass(this.type);
        container.prepend(div);
        this.init();
    },
    
    init: function() {
        //Store this as self, for use inside callbacks
        var self = this;
        $('#template-' + this.type).draggable({
            containment: "#board",
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
        var ticket = itsallagile.ticket.createFromDroppedTemplate(this, event, ui);
        ticket.init();
        ticket.render($('#board'));
        this.board.addTicket(ticket);
    }
});
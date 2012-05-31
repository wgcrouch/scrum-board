/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

itsallagile.board = itsallagile.baseObject.extend({
    id: null,
    columns: [],
    templates: [],
    trashId : '#trash' ,
    tickets : {},
    stories : {},
    render:  function() {
        var board = this.getElement();
        var templatesDiv = $('#templates');        
        for (var x in this.templates) {
            this.templates[x].render(templatesDiv);
        } 
        for (var c in this.columns) {
            this.columns[c].render(board);
        } 
        this.loadTickets();
        this.loadStories();
    },
    
    getElement: function() {
        return $(this.getCssId());
    },
    
    getCssId: function() {
        return '#board-' + this.id;
    },
    init: function() {
        var self = this;
        $(this.trashId).droppable({
            drop: function(event, ui) {
                var ticketElement = ui.draggable;
                self.removeTicket(ticketElement.data('id'));
                ui.draggable.remove();
            },
            accept: ".note"
        }); 
        itsallagile.socket.on('ticket:change', function(data) {
            self.refreshTicket(data);
        });
        
        itsallagile.socket.on('ticket:create', function(data) {
            self.addCreatedTicket(data);
        });
        
        itsallagile.socket.on('ticket:delete', function(ticketId) {
            var ticket = self.tickets[ticketId];
            ticket.getElement().fadeOut();
            self.removeTicket(ticketId);
        });
    },
        
    refreshTicket: function(changedTicket) {
        var id = changedTicket.id;
        var ticket = this.tickets[id];
        ticket.set(changedTicket);
        ticket.refresh(this.getElement());
    },
    
    addCreatedTicket: function(newTicket) {
        var ticket = itsallagile.ticket.extend(newTicket);
        this.addTicket(ticket);
        ticket.render(this.getElement());
    },
    
    addTemplate: function(template) {
        template.board = this;
        this.templates.push(template);
    },
    
    removeTicket: function(ticketId) {
        this.tickets[ticketId].erase();
        delete this.tickets[ticketId];
    },
    addColumn: function(column) {
        this.columns.push(column);
    },
    
    addTicket: function(ticket) {
        this.tickets[ticket.id] = ticket;
    },
    
    addStory: function(story) {
        this.stories[story.id] = story;
    },
    
    removeStory: function(storyId) {
        this.stories[storyId].erase();
        delete this.stories[storyId];
    },
    
    loadTickets:function() {
        var self = this;
        $.get('/tickets/board/' + this.id, null, function(data, textStatus, jqXHR) {
            for(var ticketId in data) {
                if (data.hasOwnProperty(ticketId)) {
                    var ticket = itsallagile.ticket.extend(data[ticketId]);
                    self.addTicket(ticket);
                    ticket.render(self.getElement());
                }
            }
        }, 'json');
    },
    
    loadStories:function() {
        var self = this;
        $.get('/stories/board/' + this.id, null, function(data, textStatus, jqXHR) {
            for(var storyId in data) {
                if (data.hasOwnProperty(storyId)) {
                    var story = itsallagile.story.extend(data[storyId]);
                    self.addStory(story);
                    story.render(self.getElement());
                }
            }
        }, 'json');
    }
});

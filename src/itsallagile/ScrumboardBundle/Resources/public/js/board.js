/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

itsallagile.board = itsallagile.baseObject.extend({
    id: 'board',
    columns: [],
    templates: [],
    trashId : '#trash' ,
    tickets : {},
    stories : {},
    render:  function() {
        var board = $('#' +  this.id);
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
    },
        
    addTemplate: function(template) {
        template.board = this;
        this.templates.push(template);
    },
    
    removeTicket: function(ticketId) {
        var element = $('#' . ticketId);
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
        var element = $('#' . storyId);
        this.stories[storyId].erase();
        delete this.stories[storyId];
    },
    
    loadTickets:function() {
        var self = this;
        $.get('/tickets', null, function(data, textStatus, jqXHR) {
            for(var ticketId in data) {
                if (data.hasOwnProperty(ticketId)) {
                    var ticket = itsallagile.ticket.extend(data[ticketId]);
                    self.addTicket(ticket);
                    ticket.render($('#' +  self.id));
                }
            }
        }, 'json');
    },
    
    loadStories:function() {
        var self = this;
        $.get('/stories', null, function(data, textStatus, jqXHR) {
            for(var storyId in data) {
                if (data.hasOwnProperty(storyId)) {
                    var story = itsallagile.story.extend(data[storyId]);
                    self.addStory(story);
                    story.render($('#' +  self.id));
                }
            }
        }, 'json');
    }
});

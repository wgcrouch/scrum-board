/**
 * View for tickets
 */
itsallagile.View.Ticket = Backbone.View.extend({
    tagName: 'div',
    className: 'ticket',
    template: '<p class="ticket-content">' +
        '<%= content %></p><textarea class="ticket-input"><%= content %></textarea>' +
        '<div class="ticket-actions">' +
        '<i class="icon-zoom-in zoom-ticket ticket-action"></i>' +
        '<i class="icon-remove delete-ticket ticket-action"></i>' +
        '</div>',
    events: {
        "dblclick": "startEdit",
        "blur textarea": "endEdit",
        'hover' : 'toggleShowIcons',
        'mouseOut' : 'toggleShowIcons',
        'click .delete-ticket' : 'deleteConfirm',
        'click .zoom-ticket' : 'zoomToggle'
    },
    storyView: null,

    /**
     * Initialize bindings to changes in the model
     */
    initialize: function(options) {
        this.story = options.story;
        this.storyView = options.storyView;
        _.bindAll(this);
    },

    /**
     * Render a ticket
     */
    render: function() {
        this.id = this.model.get('id');
        this.$el.addClass(this.model.get('type'));
        this.$el.append(_.template(this.template, {content : this.model.get("content")}));
        $('p', this.$el).html(this.formatText($('p', this.$el).html()));
        this.$el.data('ticketId', this.model.get('id'));
        this.$el.data('story', this.story.get('id'));
        this.$el.data('status', this.model.get('status'));
        this.$el.draggable({revert: true});
        return this;
    },

    /**
     * Show the edit box when ticket is double clicked
     */
    startEdit: function() {
        if (!$('p', this.$el).is(':hidden') && !this.$el.hasClass('zoomed')) {
            this.zoomToggle();
        }
        $('p',this.$el).hide();
        $('textarea', this.$el).show().focus();
    },

    /**
     * Save the ticket when editing has finished
     */
    endEdit: function() {
        var p = $('p', this.$el);
        var text = $('textarea', this.$el);
        p.html(this.formatText(text.val()));
        text.hide();
        p.show();
        this.model.set('content', text.val());
        this.model.save(null, {success: this.changeSuccess});
        if (this.$el.hasClass('zoomed')) {
            this.zoomToggle();
        }
    },

    /**
     * Callback function for successfully changing a tickets contents
     */
    changeSuccess: function(model, response) {
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('boardEvent', itsallagile.roomId, 'ticket:change', response);
        }
    },

    /**
     * Show the delete icon when hovering over a ticket
     */
    toggleShowIcons: function() {
        $('.ticket-actions', this.$el).fadeToggle('fast');
    },

    /**
     * Zoom in/out of a ticket
     */
    zoomToggle: function() {
        var speed = 300;
        if (this.$el.hasClass('zoomed')) {
            this.$el.removeClass('zoomed');
            this.$el.animate({width:90, height:90}, speed);
            $('.zoom-ticket', this.$el).removeClass('icon-zoom-out').addClass('icon-zoom-in');
        } else {
            this.$el.addClass('zoomed');
            this.$el.animate({width:190, height:190}, speed);
            $('.zoom-ticket', this.$el).removeClass('icon-zoom-in').addClass('icon-zoom-out');
        }
    },

    /**
     * Show a dialog to confirm deleting a ticket
     */
    deleteConfirm: function(event) {
        if (confirm('Are you sure you want to delete this ticket?')) {
            this.model.destroy({silent: true, success: this.onDeleteSuccess});
            this.$el.fadeOut();
        } else {
            event.preventDefault();
            event.stopPropagation();
        }
    },
    
    /**
     * Send the delete event and show a notification when a ticket is successfully deleted
     */
    onDeleteSuccess: function(ticket) {
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit(
                'boardEvent', 
                itsallagile.roomId, 
                'ticket:delete', 
                { 
                    ticket: ticket.toJSON(),
                    storyId: this.story.get('id')
                }
            );
        }
        var notification = new itsallagile.View.Notification({
            message: 'Ticket deleted successfully',
            type: 'success'
        });
        notification.render();
    },

    /**
     * Dodgy formatter for text in tickets, should be refactored into a different view or helper
     */
    formatText: function(text) {
        var breakTag = '<br/>';
        return (text + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

});

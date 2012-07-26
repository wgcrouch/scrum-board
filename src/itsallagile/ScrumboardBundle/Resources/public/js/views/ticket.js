/**
 * View for tickets
 */
itsallagile.View.Ticket = Backbone.View.extend({
    tagName: 'div',
    className: 'ticket',
    template: '<p class="ticket-content"><%= content %></p><textarea class="ticket-input"><%= content %></textarea><i class="icon-remove delete-ticket"></i>',
    events: {
        "dblclick": "startEdit",
        "blur textarea": "endEdit",
        'hover' : 'toggleShowDelete',
        'mouseOut' : 'toggleShowDelete',
        'click .delete-ticket' : 'deleteConfirm'
    },
    storyView: null,
    
    //Initialize bindings to changes in the model
    initialize: function(options) {
        this.model.bind('change', this.refresh);
        this.model.bind('sync', this.refresh);
        this.storyView = options.storyView;
        _.bindAll(this);
    },
    
    //Render a ticket
    render: function() {
        this.id = this.model.get('id');
        this.$el.addClass(this.model.get('type'));
        this.$el.append(_.template(this.template, {content : this.model.get("content")}));    
        this.$el.data('cid', this.model.cid);
        this.$el.data('story', this.model.get('story'));
        this.$el.data('status', this.model.get('status'));
        this.$el.draggable({revert: true});
        return this;
    },
    
    //Show the edit box when ticket is double clicked
    startEdit: function() {
        $('p',this.$el).hide();
        $('textarea', this.$el).show().focus();
    },
    
    //Save the ticket when editing has finished
    endEdit: function() {
        var p = $('p', this.$el);
        var text = $('textarea', this.$el);
        p.html(text.val());
        text.hide();
        p.show();
        this.model.set('content', text.val());
        this.model.save(null, {success: this.changeSuccess});
       
    },
    
    //Callback function for successfully changing a tickets contents
    changeSuccess: function(model, response) {
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('ticket:change', itsallagile.roomId, response);
        }
    },
    
    toggleShowDelete: function() {
        $('.delete-ticket', this.$el).fadeToggle('fast');
    },
    
    deleteConfirm: function(event) {
        if (confirm('Are you sure you want to delete this ticket?')) {
            this.model.destroy({silent: true});
            this.$el.fadeOut();
            if (typeof itsallagile.socket !== 'undefined') {
                itsallagile.socket.emit('ticket:delete', itsallagile.roomId, this.model.toJSON());
            }
        } else {
            event.preventDefault();
            event.stopPropagation();
        }
    }
    
});





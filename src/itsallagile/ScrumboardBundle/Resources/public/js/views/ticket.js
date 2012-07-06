itsallagile.View.Ticket = Backbone.View.extend({
    tagName: 'div',
    className: 'ticket',
    template: '<p class="ticket-content"><%= content %></p><textarea class="ticket-input"><%= content %>',
    events: {
        "dblclick": "startEdit",
        "blur textarea": "endEdit"
    },
    
    initialize: function(options) {
        this.model.bind('change', this.refresh);
        this.model.bind('sync', this.refresh);
    },
    
    render: function() {
        this.id = this.model.get('id');
        this.$el.addClass(this.model.get('type'));
        this.$el.append(_.template(this.template, {content : this.model.get("content")}));        
        return this;
    },
    
    startEdit: function() {
        $('p',this.$el).hide();
        $('textarea', this.$el).show().focus();
    },
    
    endEdit: function() {
        var p = $('p',this.$el);
        var text = $('textarea', this.$el);
        p.html(text.val());
        text.hide();
        p.show();
        this.model.set('content', text.val());
        this.model.save();
       
    }
    
});





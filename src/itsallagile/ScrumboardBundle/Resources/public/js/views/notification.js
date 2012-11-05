/**
 * Notification view
 */
itsallagile.View.Notification = Backbone.View.extend({
    tagName: 'p',
    className: 'alert',
    message: null,
    type: null,

    initialize: function(options) {
        this.message = options.message;
        this.type = options.type;
    },

    /**
     * Render a notification
     */
    render: function() {
        var el = this.$el;
        el.text(this.message);
        el.addClass('alert-' + this.type);
        $('#notification-container').append(el);
        setTimeout(function() {
            el.fadeOut(function(){
                $(this).remove();
            });
        }, 4000)
        return this;
    }
});
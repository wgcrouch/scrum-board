/**
 * View class for a story status select
 */
itsallagile.View.StoryStatus = Backbone.View.extend({
    tagName: 'select',
    className: 'story-status',
    template: '<option value="<%= value %>"<%= selected %>><%= displayValue %></option>',
    statuses: [],
    status: null,

    initialize: function(options) {
        this.statuses = options.statuses;
        this.status = options.status;
    },    

    events: {},

    render: function() {      
        var html = '';
        for (var i = 0; i < this.statuses.length; i++) {
            var status = this.statuses[i];
            var data = {value: status.id, displayValue: status.status, selected: ''};
            if (status.id == this.status) {
                data.selected = 'selected="selected"';
            }
            html += _.template(this.template, data);
        }
        this.$el.html(html);

        return this;
    }
});
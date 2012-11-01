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
        this.statuses.forEach(function(status) {
            var statusId = status.get('id');
            var data = {value: statusId, displayValue: status.get('name'), selected: ''};
            if (statusId == this.status) {
                data.selected = 'selected="selected"';
            }
            html += _.template(this.template, data);
        }, this);
        this.$el.html(html);

        return this;
    }
});
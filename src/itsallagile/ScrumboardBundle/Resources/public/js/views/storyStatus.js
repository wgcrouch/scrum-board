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
        for (var i = 0; i < this.statuses; i++) {
            var status = this.statuses[i];
            var data = {value: status, displayValue: status, selected: ''};
            if (status == this.status) {
                data.selected = 'selected="selected"';
            }
            html += _.template(this.template, data);
        }
        this.$el.html(html);

        return this;
    }
});
'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash'),
    Ticket = require('components/Board/Ticket.jsx');

var StoryCell = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        story: React.PropTypes.object.isRequired,
        column: React.PropTypes.object.isRequired 
    },   

    renderTickets: function() {
        var column = this.props.column,
            story = this.props.story;

        var tickets = _.filter(column.tickets, function(ticket) {
            return ticket.story_id == story.id;
        }, this);

        return _.map(tickets, function(ticket) {
            /* jshint ignore:start */
            return <Ticket key={ticket.id} ticket={ticket}/>
            /* jshint ignore:end */
        });
    },
    
    render: function() {
        var story = this.props.story;
        /* jshint ignore:start */
        return (
            <td>{this.renderTickets()}</td>
        );
        /* jshint ignore:end */
    }

});

module.exports = StoryCell;
'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash'),
    Ticket = require('components/Board/Ticket.jsx');

var Ticket = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        ticket: React.PropTypes.object.isRequired
    },   

    render: function() {
        var ticket = this.props.ticket;

        /* jshint ignore:start */
        return (
            <div className="ticket">{ticket.content}</div>
        );
        /* jshint ignore:end */
    }

});

module.exports = Ticket;
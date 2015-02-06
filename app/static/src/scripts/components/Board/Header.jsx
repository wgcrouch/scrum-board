'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash');

var Header = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        columns: React.PropTypes.array        
    },

    getDefaultProps: function() {
        return {
            columns: []
        };
    },

    renderColumnCells: function() {
        return _.map(this.props.columns, function(column) {
            /* jshint ignore:start */
            return <th className="column-header-cell" key={column.id}>{column.title}</th>
            /* jshint ignore:end */
        });
    },

    render: function() {
        /* jshint ignore:start */
        return (
            <thead>
                <tr className="column-headers"><th className="column-header-cell"/>{this.renderColumnCells()}</tr>
            </thead>
        );
        /* jshint ignore:end */
    }

});

module.exports = Header;
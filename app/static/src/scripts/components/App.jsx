'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin,
    Board = require('components/Board.jsx');

var AppComponent = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {

    },

    getDefaultProps: function() {
        return {
            
        };
    },

    render: function() {
        /* jshint ignore:start */
        return (
            <div>
                <Board />
            </div>
        );
        /* jshint ignore:end */
    }

});

module.exports = AppComponent;
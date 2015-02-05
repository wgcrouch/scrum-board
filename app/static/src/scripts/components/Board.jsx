'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin;

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
            <div className="board-container">
                <h2>Board</h2>
                <div className="toolbar">Tools</div>
                <table className="board">
                </table>
            </div>
        );
        /* jshint ignore:end */
    }

});

module.exports = AppComponent;
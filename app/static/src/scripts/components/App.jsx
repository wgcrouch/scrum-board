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
            <div>App
            </div>
        );
        /* jshint ignore:end */
    }

});

module.exports = AppComponent;
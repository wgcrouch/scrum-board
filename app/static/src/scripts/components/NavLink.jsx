'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin,
    RoutingActions = require('actions/Routing');

var NavLink = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        href: React.PropTypes.string,
        className: React.PropTypes.string,
    },

    getDefaultProps: function() {
        return {
            href: '/',
            className: ''
        };
    },

    handleClick: function(e) {        
        var target = e.target;  
        // if the user was holding a modifier key, don't intercept
        if (!e.altKey && !e.ctrlKey && !e.shiftKey && !e.metaKey) {
            e.preventDefault();            
            RoutingActions.changeUrl(this.props.href, false);
        }
        
    },

    render: function() {
        /* jshint ignore:start */
        return (
            <a onClick={this.handleClick} href={this.props.href} className={this.props.className}>
                {this.props.children}
            </a>
        );
        /* jshint ignore:end */
    }

});

module.exports = NavLink;
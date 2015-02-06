'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash'), 
    Board = require('stores/Records').Board;

var Body = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        board: React.PropTypes.instanceOf(Board)        
    },

    getDefaultProps: function() {
        return {
            board: new Board()
        };
    },

    renderStories: function() { 
        return _.map(this.props.board.stories, function(story) {
            /* jshint ignore:start */
            return (
                <tr key={story.id}>
                    <th><p>{story.title}</p><p>{story.content}</p></th>
                </tr>
            );
            /* jshint ignore:end */
        });
    },

    render: function() {
        /* jshint ignore:start */
        return (
            <tbody>
                {this.renderStories()}
            </tbody>
        );
        /* jshint ignore:end */
    }

});

module.exports = Body;
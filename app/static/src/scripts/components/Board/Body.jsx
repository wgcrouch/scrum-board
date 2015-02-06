'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash'), 
    Board = require('stores/Records').Board,
    Story = require('components/Board/Story.jsx');

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
        var board = this.props.board;
        return _.map(board.stories, function(story) {
            /* jshint ignore:start */
            return <Story key={story.id} story={story} columns={board.columns} />
            /* jshint ignore:end */
        }, this);
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
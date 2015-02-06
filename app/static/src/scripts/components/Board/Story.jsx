'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    _ = require('lodash'),
    StoryCell = require('components/Board/StoryCell.jsx');

var Story = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        story: React.PropTypes.object.isRequired,
        columns: React.PropTypes.array.isRequired 
    },
   
    renderStoryCells: function() {
        var story = this.props.story;
        return _.map(this.props.columns, function(column) {
            /* jshint ignore:start */
            return <StoryCell key={story.id + '-' + column.id} column={column} story={story} />
            /* jshint ignore:end */            
        }, this);
    },

    render: function() {
        var story = this.props.story;
        /* jshint ignore:start */
        return (
            <tr key={story.id}>
                <th><p>{story.title}</p><p>{story.content}</p></th>
                {this.renderStoryCells()}
            </tr>
        );
        /* jshint ignore:end */
    }

});

module.exports = Story;
'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin,
    Immutable = require('immutable'),
    BoardStore = require('stores/Board'),
    NavLink = require('components/NavLink.jsx');

function getStateFromStores() {
    return {
        boards: BoardStore.getAll()
    };
}

var BoardList = React.createClass({
    mixins: [PureRenderMixin],

    getInitialState: function () {
        return getStateFromStores();
    },

    componentDidMount: function () {
        BoardStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function () {
        BoardStore.removeChangeListener(this._onChange);
    },

    _onChange: function () {
        this.setState({
            boards: BoardStore.getAll()
        });
    },


    render: function() {

        var boards = this.state.boards.get('boards').map(function(board) {
            /* jshint ignore:start */
            return <li key={board.id}><NavLink href={'/boards/' + board.id}>{board.title}</NavLink></li>
            /* jshint ignore:end */
        }, this);        
        /* jshint ignore:start */
        return (
            <div className="board-list">
                <h2>Boards</h2>
                <ul>
                    {boards.toJS()}
                </ul>                
            </div>
        );
        /* jshint ignore:end */
    }

});

module.exports = BoardList;
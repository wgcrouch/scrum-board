'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin, 
    NavLink = require('components/NavLink.jsx'), 
    BoardStore = require('stores/Board'),
    BoardHeader = require('components/Board/Header.jsx'),
    BoardBody = require('components/Board/Body.jsx');

var Board = React.createClass({
    mixins: [PureRenderMixin],

    propTypes: {    
        boardId: React.PropTypes.string,        
    },

    getStateFromStores: function() {
        return {
            board: BoardStore.get(this.props.boardId)
        };
    },

    getInitialState: function () {
        return this.getStateFromStores();
    },

    componentDidMount: function () {
        BoardStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function () {
        BoardStore.removeChangeListener(this._onChange);
    },

    _onChange: function () {
        this.setState({
            board: BoardStore.get(this.props.boardId)
        });
    },

    render: function() {
        /* jshint ignore:start */
        return (
            <div className="board-container">
                <NavLink>Back to List</NavLink>
                <h2>{this.state.board.title}</h2>
                <div className="toolbar">Tools</div>
                <table className="board">   
                    <BoardHeader columns={this.state.board.columns}/>                 
                    <BoardBody board={this.state.board}/>  
                </table>
            </div>
        );
        /* jshint ignore:end */
    }

});

module.exports = Board;
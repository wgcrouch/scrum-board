'use strict';
var Dispatcher = require('dispatcher/Dispatcher'),
    Store = require('stores/Store'),
    _ = require('lodash'),
    Immutable = require('immutable'),
    BoardService = require('services/BoardService'),
    ActionTypes = require('constants/AppConstants').ActionTypes,
    Board = require('stores/Records').Board;


var boards = Immutable.Map({
    'loading': false,
    'boards': Immutable.List(),
    'loaded': false
});



var receiveBoards = function(boardsResponse) {
    var boardList = _.map(boardsResponse, function(board) {
        return new Board(board);
    });
    boards = boards.set('boards', Immutable.List(boardList));
    boards = boards.set('loading', false);
    boards = boards.set('loaded', true);
};

var BoardStore = _.extend({}, Store.prototype, {

    //This store gets its state asynchronously
    getAll: function () {
        if (!boards.get('loaded') && !boards.get('loading')) {
            boards = boards.set('loading', true);
            BoardService.getBoards()
                .done(function(response) {
                    receiveBoards(response.body.boards);
                    BoardStore.emitChange();
                });
        }
        return boards;
    },

    get: function(boardId) {
        var allBoards = this.getAll().get('boards');
        return allBoards.find(function(board) {return board.id == boardId;}) || new Board();
    }
});


BoardStore.dispatchToken = Dispatcher.register(function (payload) {
    var action = payload.action;

    switch (action.type) {
        

    }

    return true;

});


module.exports = BoardStore;

'use strict';
/**
 * Service to interact with the site resource
 */

var client = require('services/ApiClient');

var BoardService = {

    getBoards: function(type, number) {
        var url = '/api/boards';
        return client.get(url, {});
    }
};

module.exports = BoardService;

'use strict';
var Dispatcher = require('dispatcher/Dispatcher'),
    ActionTypes = require('constants/AppConstants').ActionTypes;

module.exports = {
    changeUrl: function(href, fromHistory) {
        Dispatcher.handleAction({
            type: ActionTypes.NAVIGATE,
            href: href,
            fromHistory: fromHistory
        });
    }
};

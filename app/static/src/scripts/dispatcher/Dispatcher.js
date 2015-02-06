//Basic Flux Dispatcher

'use strict';
var Dispatcher = require('flux').Dispatcher,
    _ = require('lodash');

var EditorDispatcher = _.extend(new Dispatcher(), {

    handleAction: function(action) {
        var payload = {
            action: action
        };
        this.dispatch(payload);
    }
});

module.exports = EditorDispatcher;

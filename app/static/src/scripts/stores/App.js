'use strict';
var Dispatcher = require('dispatcher/Dispatcher'),
    Store = require('stores/Store'),
    _ = require('lodash'),
    Immutable = require('immutable'),
    ActionTypes = require('constants/AppConstants').ActionTypes,
    History = require('flux-router-component').History,
    RouteRecognizer = require('route-recognizer'), 
    Route = require('stores/Records').Route;



var router = new RouteRecognizer();
router.add([{path: '/', handler: 'board-list'}]);
router.add([{path: '/boards/:boardId', handler: 'board'}]);



var routeFromRouteMatch = function(href, routeMatch) {
    return new Route({
        href: href,
        name: routeMatch.handler,
        params: routeMatch.params
    });
};

var getInitialRoute = function() {
    var initialPath = document.location.toString().replace(document.location.origin, '');
    var routes = router.recognize(initialPath);

    var initialRoute = new Route();
    if (routes && routes.length) {
        initialRoute = routeFromRouteMatch(initialPath, routes[0]);
    } 
    return initialRoute;
};


var app = Immutable.Map({
    currentRoute: getInitialRoute()
});


var AppStore = _.extend({}, Store.prototype, {

    get: function () {        
        return app;
    },
});

var handleNavigate = function(href, skipHistory) {
    var results = router.recognize(href);
    if (results && results.length) {
        var route = results[0];

        app = app.set('currentRoute', routeFromRouteMatch(href, route));

        if (!skipHistory) {
            window.history.pushState(href, '', href);
        }        
    }       
};

AppStore.dispatchToken = Dispatcher.register(function (payload) {
    var action = payload.action;

    switch (action.type) {
        case ActionTypes.NAVIGATE:
            handleNavigate(action.href, action.fromHistory);            
            AppStore.emitChange();
            break;
    }

    return true;

});


module.exports = AppStore;

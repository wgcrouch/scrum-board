'use strict';
var React = require('react/addons'),
    AppComponent = require('components/App.jsx');

//Set up react dev tools
window.React = React;


var Scrum = window.Scrum || {};

Scrum.App =  function(config, initialData) {

    if (config.debug) {
        var Perf = React.addons.Perf;
        this.perf = Perf;
    }
};

Scrum.App.prototype.render = function(element) {
    var app = React.render(
        /* jshint ignore:start */
        <AppComponent />, element
        /* jshint ignore:end */ 
    );
    return app;
};

window.Scrum = Scrum;
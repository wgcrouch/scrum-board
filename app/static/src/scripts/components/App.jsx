'use strict';

var React = require('react/addons'),
    PureRenderMixin = React.addons.PureRenderMixin,
    BoardList = require('components/BoardList.jsx'),
    Board = require('components/Board.jsx'),
    AppStore = require('stores/App'),
    RoutingActions = require('actions/Routing');

function getStateFromStores() {
    return {
        app: AppStore.get()
    };
}

var AppComponent = React.createClass({
    mixins: [PureRenderMixin],

    getInitialState: function () {
        return getStateFromStores();
    },

    componentDidMount: function () {        
        AppStore.addChangeListener(this._onChange);


        // Some browsers have some weirdness with firing an extra 'popState'
        // right when the page loads
        var firstPopState = true;

        window.onpopstate = function(e) {
            if (firstPopState) {
                firstPopState = false;
                return;
            }
            var path = document.location.toString().replace(document.location.origin, '');
            RoutingActions.changeUrl(path, true);
        }.bind(this);
    },

    componentWillUnmount: function () {
        AppStore.removeChangeListener(this._onChange);
    },

    _onChange: function () {
        this.setState({
            app: AppStore.get()
        });
    },

    renderComponentFromRoute: function() {
        var currentRoute = this.state.app.get('currentRoute');
        var component = '';
        switch (currentRoute.name) {            
            case 'board':
                /* jshint ignore:start */
                return <Board {...currentRoute.params}/>
                /* jshint ignore:end */
                break;
            default: 
                /* jshint ignore:start */
                return <BoardList {...currentRoute.params}/>
                /* jshint ignore:end */
                break;
        }
        return component;
    },

    render: function() {                
        /* jshint ignore:start */
        return (            
            <div>
                {this.renderComponentFromRoute()}                
            </div>
        );
        /* jshint ignore:end */
    },

    componentDidUpdate: function(prevProps, prevState) {
        var newState = this.state;
        if (newState.pageTitle === prevState.pageTitle) {
            return;
        }
        document.title = newState.pageTitle;
    }

});

module.exports = AppComponent;
var Immutable = require('immutable');

var Board = Immutable.Record({
    id: null, 
    title:null, 
    updated:null, 
    created:null, 
    stories: [], 
    columns: []}
);

var Route = Immutable.Record({
    href: '/',
    name: 'home',
    params: {}
});

module.exports = {
    Board: Board,
    Route: Route
};
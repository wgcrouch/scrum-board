/**
 * Set up some variables for the directories used in other tasks
 *
 * Usage: <%= dirs.build %>
 *
 */

var path = process.env.BUILD_PATH || '.',
    version = process.env.REVISION,
    dir = ['app', 'static', 'build',  version].join('/');


module.exports = {
    build: [path, dir].join('/'),
    source: 'app/static/src',
    bower: 'bower_components'
};
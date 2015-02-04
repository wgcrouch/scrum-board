/**
 * Jshint grunt config
 *
 * see http://www.jshint.com/
 */

module.exports = {
	all: ['<%= dirs.source %>/scripts/**/*.js*'],
    options: {
        browser: true,
        node: true, //Allow browserify require statement and file level use strict
        expr: true
    }
};

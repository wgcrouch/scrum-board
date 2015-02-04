/**
 * Minify the compiled javascript files using uglify
 *
 * see https://github.com/gruntjs/grunt-contrib-uglify
 */

module.exports = {
    dist: {
        files: {
            '<%= dirs.build %>/scripts/App.js' : ['<%= dirs.build %>/scripts/App.js']
        }
    }
};

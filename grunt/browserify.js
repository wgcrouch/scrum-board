/**
 * Browserify grunt config
 *
 * see http://browserify.org/ and https://github.com/jmreidy/grunt-browserify
 */


//These are the top level "apps" we build
var files = {
    '<%= dirs.build %>/scripts/App.js': ['<%= dirs.source %>/scripts/apps/App.js'],
};

module.exports = {      
    options: {
        transform: [
            "reactify", 
            "debowerify"
        ],
        browserifyOptions: {
            debug: true,
            paths: ['./node_modules','./app/static/src/scripts']
        },
        watch: true
    }, 
    
    dev: {
        files: files
    },

    prod: {
        files: files,
        options: {
            browserifyOptions: {
                debug: false,
                paths: ['./node_modules','./app/static/src/scripts']
            },
            watch: false
        }
    }
};

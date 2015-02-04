/**
 * Watch the filesystem for changes to javascript and less and run build steps
 * see https://github.com/gruntjs/grunt-contrib-watch
 */

module.exports = {
    js: {
        files: ['<%= dirs.source %>/scripts/**/*.js*'],
        tasks: ['newer:jshint', 'newer:copy'],
        options: {
            spawn: false
        }
    },
    less: {
        files: ['<%= dirs.source %>/less/**/*.less'],
        tasks: ['less:dev', 'autoprefixer:dev'],
        options: {
            spawn: false
        }
    },
    livereload: {
        files: ["<%= dirs.build %>/**/*"],
        tasks: ['newer:copy'],
        options: {
            livereload: true
        }
    }
};
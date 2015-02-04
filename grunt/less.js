/**
 * Grunt config for less files
 */

var files = [
    {
        src: ['<%= dirs.source %>/less/app.less'],
        dest: '<%= dirs.build %>/styles/app.css'
    }
];

module.exports = {
    options: {
        paths: [
            '<%= dirs.source %>/less',
            '<%= dirs.source %>/vendor',
            '<%= dirs.bower %>'
        ]
    },
    dev: {
        files: files,
        options: {
            sourceMap: true,
            outputSourceFiles: true
        }
    },
    prod: {
        files: files
    }
};

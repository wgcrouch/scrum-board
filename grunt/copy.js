/**
 * Grunt copy config
 *
 * copies images etc from the source dir to the build directory
 */

module.exports = {
    images: {
        files: [{
            expand: true,
            cwd: '<%= dirs.source %>/images/',
            src: ['**'],
            dest: '<%= dirs.build %>/images/',
            filter: 'isFile'
        }]
    }
};
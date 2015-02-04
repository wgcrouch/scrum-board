/**
 * Use autoprefixer to add browser prefixes automatically
 * see https://github.com/postcss/autoprefixer
 */

module.exports =  {
    options: {
        browsers: ["last 1 version", "> 1%", "ie 8"],
        map: true
    },

    dev: {
        expand: true,
        src: ['<%= dirs.build %>/styles/*.css', '<%= dirs.build %>/styles/themes/*.css'],
        dest: ''
    },

    prod: {
        expand: true,
        src: ['<%= dirs.build %>/styles/*.css', '<%= dirs.build %>/styles/themes/*.css'],
        dest: '',
        options: {
            map: false
        }
    }
};
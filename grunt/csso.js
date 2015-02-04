/**
 * Csso config
 *
 * see https://github.com/t32k/grunt-csso
 */

module.exports =  {
    compress: {
        options: {
            report: 'min'
        },
        files: [
            {src: ['<%= dirs.build %>/styles/app.css'], dest: '<%= dirs.build %>/styles/app.css'}            
        ]

    }
};

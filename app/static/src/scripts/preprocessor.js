'use strict';
/**
 * Preprocessor used by jest
 */
var ReactTools = require('react-tools');

var replacePath = function(src, path) {
    /**
     * HACK: This is a rather large hack to workaround
     * https://github.com/facebook/jest/issues/102
     * to allow us to get rid of relative paths in requires
     *
     * It rewrites paths to our modules with the full path
     */

    //Ignore node_modules
    if (path.match('node_modules')) {
        return src;
    }

    var rootPath = path.match(/^.*scripts\//);
    if (! rootPath) {
        throw new Error('Cannot determine rootPath for: ' + path);
    }

    rootPath = rootPath[0];

    var packages = ['actions', 'apps', 'components', 'constants', 'dispatcher', 'services', 'stores', 'utilities'];
    var out = src;
    for (var i in packages) {
        var p = packages[i];
        var re = new RegExp("require\\((['\"])" + p, 'g'); // jshint ignore:line
        out = out.replace(re, 'require($1' + rootPath + p);
    }
    return out;
};

module.exports = {
    process: function(src, file) {
        src = replacePath(src, file);

        if (!/\.jsx$/.test(file)) {
            return src;
        }

        return ReactTools.transform(src);
    }
};
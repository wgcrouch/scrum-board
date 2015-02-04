'use strict';
/**
 * Very simple i18n wrapper for now, to ensure we dont put strings in code
 * should be extended to support multiple languages, or use another system
 * later
 */
var _ = require('lodash'),
    _s = require('underscore.string');

var _dictionary = require('services/dictionary');

var _getSourceString = function(key, plural) {
    var source = _dictionary.hasOwnProperty(key) ? _dictionary[key] : key;

    if (_.isArray(source)) {
        if (plural && plural > 1) {
            return source[1];
        }
        return source[0];
    }
    return source;
};


module.exports = {
    translate : function(key, params, plural) {
        var source = _getSourceString(key, plural);
        return _s.vsprintf(source, params || []);
    },
    setDictionary: function(dictionary) {
         _dictionary = dictionary;
    }
};

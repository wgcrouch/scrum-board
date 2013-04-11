/**
 * Replaces {cos} to the end of the field with a collapsable area headed by "Conditions of satisfaction"
 */

(function(){
    var cos = function(converter) {    
        return [        
            { 
                type: 'lang',
                filter: function(text) { 
                    var regex = /\{cos\}([\s\S]*)/gmi;
                    var match = regex.exec(text);
                    if (match) {
                        var replace = '<details><summary>*Conditions of Satisfaction*</summary>';
                        replace += converter.makeHtml(match[1]);
                        replace += '</details>';
                        text = text.replace(regex, replace);
                    }
                            
                    return text;
                    
                }

            }   
        ];
    };

    // Client-side export
    if (typeof window !== 'undefined' && window.Showdown && window.Showdown.extensions) { window.Showdown.extensions.cos = cos; }
    // Server-side export
    if (typeof module !== 'undefined') module.exports = cos;
}());

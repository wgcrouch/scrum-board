/**
 *  Markdown converter class
 */
itsallagile.View.TextConverter = {};
(function(conv) {
    var converter = new Showdown.converter();
    
    conv.convert = function(text) {
        var html = converter.makeHtml(text);
        return html;
    };
}(itsallagile.View.TextConverter));




/**
 *  Markdown converter class
 */
itsallagile.View.TextConverter = {};
(function(conv) {
    var converter = new Showdown.converter({extensions: ['cos', 'table', 'github', 'dtrac', ]});
    
    conv.convert = function(text) {
        var html = converter.makeHtml(text);
        return html;
    };
}(itsallagile.View.TextConverter));




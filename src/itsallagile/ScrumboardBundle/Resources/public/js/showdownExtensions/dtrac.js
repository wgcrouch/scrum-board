//
//  Dtrac Extension
//  #ticket_no   ->  <a href="http://dtrac.affiliatewindow.com/ticket/#">#ticketNo</a>
//

(function(){

    var dtrac = function(converter) {
        return [
      
            // #hashtag syntax
            { type: 'lang', regex: '\\B(\\\\)?#([\\d]+)\\b', replace: function(match, leadingSlash, ticketNo) {
                // Check if we matched the leading \ and return nothing changed if so
                if (leadingSlash === '\\') {
                    return match;
                } else {
                    return '<a href="http://dtrac.affiliatewindow.com/ticket/' + ticketNo + '">#' + ticketNo + '</a>';
                }
            }},
        ];
    };

    // Client-side export
    if (typeof window !== 'undefined' && window.Showdown && window.Showdown.extensions) { window.Showdown.extensions.dtrac = dtrac; }
    // Server-side export
    if (typeof module !== 'undefined') module.exports = dtrac;

}());

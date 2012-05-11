/**
 * Column object. A column represents as status a ticket can be in
 */
itsallagile.column = itsallagile.baseObject.extend({
    id: null,
    title: null, 
    type: null,
    
    /**
     * Initialize the column, adding event handlers
     */
    init: function() {
//      $('#' + this.id).droppable({
//          drop: this.dropHandler
//      }); 
    },
    
    /**
     * Render the column
     */
    render: function(container) {
        var div = $('<div>').addClass('column').attr('id', this.id);
        var h = $('<h1>').html(this.title);
        div.append(h);
        container.append(div);
        this.init();
    },
    
    /**
     * Event handler for tickets dropped in a column
     */
    dropHandler: function( event, ui ) {
        
    }
    
});

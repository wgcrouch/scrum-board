/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

itsallagile.scrumboardController = itsallagile.baseObject.extend({
    
    board : null,
    
    load: function(boardId) {
        
        itsallagile.socket = io.connect(window.location.hostname + ':8080'); 
        this.board = board = itsallagile.board;
        board.init();
        board.id = boardId;
        board.addTemplate(itsallagile.storytemplate);
        board.addTemplate(itsallagile.template.extend({type: 'task'}));
        board.addTemplate(itsallagile.template.extend({type: 'test'}));
        board.addTemplate(itsallagile.template.extend({type: 'bug'}));
        board.addTemplate(itsallagile.template.extend({type: 'defect'}));
        board.addTemplate(itsallagile.template.extend({type: 'design'}));                
        board.addColumn(itsallagile.column.extend({id : 'story', type: 'story', title: 'Story'}));
        board.addColumn(itsallagile.column.extend({id : 'todo', type: 'todo', title: 'Todo'}));
        board.addColumn(itsallagile.column.extend({id : 'assigned', type: 'assigned', title: 'Assigned'}));
        board.addColumn(itsallagile.column.extend({id : 'done', type: 'done', title: 'Done'}));
        board.render();   
        itsallagile.socket.emit('subscribe', board.getRoomId());
        
        this.bindEvents();
    },
    
    bindEvents: function() {
        this.board.getElement().click(function() {
            console.log(this);
        });
    }
    
});



/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    var ticket = itsallagile.ticket.extend({type: 'task'});
    var storyColumn = $('#story');
   
    ticket.render(storyColumn);
            $( ".template" ).draggable({
                containment: "#board",
                opacity: 0.7,
                helper: "clone",
                stop: createFromTemplate

            });

            $( "#trash" ).droppable({
                drop: function( event, ui ) {
                    ui.draggable.remove();
                },
                accept: ".note"
            });


            $( ".column" ).droppable({
                drop: function( event, ui ) {
                    var ticket = {
                         colour: 'colour',
                         content: 'Content Goes here',
                         cssHash: 'aabbcc',
                         x: 100,
                         y: 200
                    };
                    $.post('/scrum-board/web/app_dev.php/ticket', ticket, function() {
                        alert('posted');
                    }, 'json');
                }

            });

            $('.note').live('dblclick', function() {
                var note =  $(this);
                var textarea = $(this).children('textarea');
                var content = $(this).children('p');
                content.hide();
                textarea.show();
                textarea.focus();

            });

            $('.note textarea').live('blur', function() {
                var textarea = $(this);
                var content = $(this).siblings('p');

                content.html(textarea.val());
                textarea.hide();
                content.show();
            });


        });


createFromTemplate = function(event, ui) {
    var newElement = $(ui.helper).clone();
    newElement.removeClass('template').addClass('note').removeClass('ui-draggable').removeClass('ui-draggable-dragging');
    $('#board').append(newElement);
    initBehaviours(newElement);

};

initBehaviours = function(element) {
    element.draggable({ containment: "#board", stack: '#board div' });
    element.resizable();
    element.droppable({
        drop: joinElements,
            accept: ".note"
        });
    };

    joinElements = function(event, ui) {
        target = $(this);
        child = ui.draggable;
        child.offset({left:0, top:80});
        target.append(child);
    }
    


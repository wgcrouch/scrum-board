/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

itsallagile.template = itsallagile.baseObject.extend();
itsallagile.template.render = function(container) {
    var div = $('<div>').addClass('template').addClass(this.type);
    console.log(div);
    container.append(div);
};


itsallagile.ticket = itsallagile.baseObject.extend();

itsallagile.ticket.createFromTemplate = function(template, event) {
    this.type = template.type;
};

itsallagile.ticket.render = function(container) {
    var div = $('<div>').addClass('note').addClass(this.type);
    var p = $('<p>').addClass('note-content');
    var text = $('<textarea>').addClass('note-input');
    div.append(p).append(text);
    container.append(div);
};
    
itsallagile.ticket.update = function()
{

}

itsallagile.ticket.join = function(parent) {

}


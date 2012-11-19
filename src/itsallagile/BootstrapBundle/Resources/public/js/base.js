
//Object.create shim
if (typeof Object.create !== "function") {
    Object.create = function (o) {
        function F() {}
        F.prototype = o;
        return new F();
    };
}

//Root namespace for our apps classes
var itsallagile = itsallagile || {};

itsallagile.Controller = {};
itsallagile.Collection = {};
itsallagile.Model = {};
itsallagile.View = {};

itsallagile.baseObject = {
    extend: function(props) {
        var prop, obj;
        obj = Object.create(this);
        for (prop in props) {
            if (props.hasOwnProperty(prop)) {
                obj[prop] = props[prop];
            }
        }
        return obj;
    },

    getSimple: function()
    {
        var simple = {};
        for (var prop in this) {
            if (this.hasOwnProperty(prop)) {
                simple[prop] = this[prop];
            }
        }
        return simple;
    }
};


/**
 * Handler for jquery ajax errors
 */
(function($) {
    
    var _errorTemplate = 
        '<div class="modal hide fade">' +
            '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                '<h3><%= header %></h3>' +
            '</div>' +
            '<div class="modal-body">' +
                '<p><%= body %></p>' +
            '</div>' +
            '<div class="modal-footer">' +
                '<button class="btn" data-dismiss="modal" aria-hidden="true"><%= buttonText %></button>' +
            '</div>' +
        '</div>';
    
    $(document).ajaxError(function(e, jqxhr, settings, exception) {
        var status = jqxhr.status;
        var data = {
            header: 'An error has occurred',
            body: 'An error has occurred with your request. Please try again. If the error persists try refreshing the page',
            buttonText: 'Close'
        };
        var hideAction = function() {
        };
        if (status == 403) {
            data.header = 'Session Expired';
            data.body = 'Your session has expired, please login again.';
            data.buttonText = 'Go To Login Page';
            hideAction = function() {
                window.location = '/login';
            }
        }
        
        var modal = $(_.template(_errorTemplate, data));
        modal.on('hide', hideAction);
        modal.modal({show: true});
    });
}(jQuery))

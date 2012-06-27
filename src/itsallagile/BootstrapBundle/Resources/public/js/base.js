
//Object.create shim
if (typeof Object.create !== "function") {
    Object.create = function (o) {
        function F() {}
        F.prototype = o;
        return new F();
    };
}


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

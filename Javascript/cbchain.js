// Quelle: https://lennybacon.com/post/2011/10/03/chainingasynchronousjavascriptcalls
var CallbackChain = function () {
    var cs = [];
    this.add = function (call) {
        cs.push(call);
    };
    this.execute = function () {
        var wrap = function (call, callback) {
            return function () {
                call(callback);
            };
        };
        for (var i = cs.length-1; i > -1; i--) {
            cs[i] = wrap(cs[i], i < cs.length - 1 ? cs[i + 1] : null);
        }
        cs[0]();
    };
};

// Beispiel
var cc = new CallbackChain();
cc.add( function(cb){console.log(1);if (cb!=null)cb();} );
cc.add( function(cb){console.log(2);if (cb!=null)cb();} );
cc.add( function(cb){console.log(3);if (cb!=null)cb();} );
cc.execute();

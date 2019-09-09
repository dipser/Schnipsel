// Object to array (ES8, 2017)
if (!Object.values) { Object.values = function (obj) { return Object.keys(obj).map(function(key) { return obj[key]; }); } } // Internet Explorer fix
var values = Object.values( {a:1, b:2} ); // => [1,2]

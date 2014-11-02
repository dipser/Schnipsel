// jApp() ruft jApp.fn.init() auf und liefert den return zurück.
// jApp.fn.init() ist zu diesem Zeitpunkt noch nicht existent.
var jApp = (function(){
  var jApp = function () {
    return new jApp.fn.init();
  };
  return jApp;
})();

// jApp wird an window übergeben
window.$ = window.jApp = jApp;

// Dem Funktionsobjekt von jApp wird ergänzt mit Methoden/Eigenschaften als Objekt (z.B. init)
// und in fn ablegt
jApp.fn = jApp.prototype = {
  init: function () {
    console.log('INIT');
  },
  awesome: function () {
    console.log('AWESOME');
    return jApp.fn;
  }
}
jApp.fn.init.prototype = jApp.fn;

jApp.fn.foo = function(){
  console.log('FOO');
};

jApp().awesome();
jApp().awesome().awesome();
jApp().foo();

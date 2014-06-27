// Unix Zeitstempel (=ohne ms) mit der Möglichkeit Werte auf 0 zu setzen
function unix_timestamp(y=true, m=true, d=true, h=true, i=true, s=true) {
  var now = new Date();
  var start = new Date(
    (y ? now.getFullYear() : 0),
    (m ? now.getMonth() : 0),
    (d ? now.getDate() : 0),
    (h ? now.getHours() : 0),
    (i ? now.getMinutes() : 0),
    (s ? now.getSeconds() : 0)
  );
  return start / 1000;
};

// Unix Zeitstempel (=ohne ms) mit der Möglichkeit Werte auf 0 zu setzen
function unix_timestamp(y, m, d, h, i, s) {
  var now = new Date();
  if (y==false) { now.setFullYear(0); }
  if (m==false) { now.setMonth(0); }
  if (d==false) { now.setDate(0); }
  if (h==false) { now.setHours(0); }
  if (i==false) { now.setMinutes(0); }
  if (s==false) { now.setSeconds(0); }
  return Math.round(now.getTime() / 1000);
}

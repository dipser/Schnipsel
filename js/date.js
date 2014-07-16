function date(format, timestamp) { // format: http://php.net/manual/de/function.date.php; timestamp: 2014-07-01
	format = typeof format !== 'undefined' ? format : '';
	timestamp = typeof timestamp !== 'undefined' ? timestamp : new Date();
  
  	var pad = function(i) { return (i < 10) ? "0" + i : "" + i; };
  	var days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
	var months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
	var d = new Date(timestamp);
  
	return format.replace(/\\?[a-zA-Z]{1,1}/g, function(m) {
		if (m[0]=='\\') { return m[1]; }
		// Tag
		if (m[0]=='d') { return pad(d.getDate()); }
		if (m[0]=='D') { return days[d.getDay()].slice(0, 3); }
		if (m[0]=='j') { return d.getDate(); }
		if (m[0]=='l') { return days[d.getDay()]; }
		// Monate
		if (m[0]=='F') { return months[d.getMonth()]; }
		if (m[0]=='m') { return pad(d.getMonth() + 1); }
		if (m[0]=='M') { return months[d.getMonth()].slice(0, 3); }
		if (m[0]=='n') { return d.getMonth() + 1; }
		if (m[0]=='t') { return new Date(d.getFullYear(), d.getMonth()+1, 0).getDate(); }
		// Jahre
		if (m[0]=='Y') { return d.getFullYear(); }
		if (m[0]=='y') { return d.getFullYear().toString().slice(2); }
		return m;
	});
}
//date('l, d. F Y \\F m n y M D x', '2014-07-01');


function date2(format, timestamp) {
	format = typeof format !== 'undefined' ? format : '';
	timestamp = typeof timestamp !== 'undefined' ? timestamp : new Date();
	
	var d = new Date(timestamp);
	var today = new Date();
	var tomorrow = new Date( new Date().setDate(new Date().getDate() + 1) );
	var dayaftertomorrow = new Date( new Date().setDate(new Date().getDate() + 2) );
	
	if (d.toDateString() == today.toDateString()) {
		return 'Heute';
	}
	if (d.toDateString() == tomorrow.toDateString()) {
		return 'Morgen';
	}
	if (d.toDateString() == dayaftertomorrow.toDateString()) {
		return 'Übermorgen';
	}
	
	return date(format, timestamp);
}





function dateToday(date) { // date: "2012-02-20"
  date = typeof date !== 'undefined' ? date : new Date(); // Default
  var d = new Date(date);
  return d.getDate();
}

function dateTomorrow(date) { // date: "2012-02-20"
  date = typeof date !== 'undefined' ? date : new Date(); // Default
  var d = new Date(date);
  return d.setDate(d.getDate() + 1);
}

function dateDayaftertomorrow(date) { // date: "2012-02-20"
  date = typeof date !== 'undefined' ? date : new Date(); // Default
  var d = new Date(date);
  return d.setDate(d.getDate() + 2);
}

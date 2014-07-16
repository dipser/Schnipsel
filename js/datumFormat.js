function datumFormat(datum) { // datum: 2014-07-16 => return: Mittwoch, 16. Juli 2014
  //var specialDayString = ['Heute', 'Morgen', 'Übermorgen'];
  var dayString = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
  var monthString = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
  var d = datum.split('-');
  var year = d[0], month = d[1], day = d[2];
  var datesDay = new Date(parseInt(year), parseInt(month)-1, parseInt(day)).getDay(); // 0-6
  return dayString[datesDay] +', '+ day +'. '+ monthString[parseInt(month)-1] +' '+ year;
}

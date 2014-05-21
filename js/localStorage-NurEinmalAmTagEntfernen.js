var currentDate = new Date();
var day = currentDate.getDate();
var month = currentDate.getMonth() + 1;
var year = currentDate.getFullYear();
var today = year+''+month+''+day;
if (localStorage.getItem('today') === null) {
  // Set localstorage timestamp
  localStorage.setItem('today', today);
} else {
  // Clear localstorage if not today
  if (localStorage.getItem('today') != today) {
    localStorage.clear();
    localStorage.setItem('today', today);
  }
}

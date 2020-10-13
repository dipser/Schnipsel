/**
 * Bootstrap Touch Nav: Touble Tap to open dropdown
 */
document.getElementById('#site-nav .dropdown-toggle').addEventListener('touchstart', function() {
    // if input needs double tap 
    this.focus();
});

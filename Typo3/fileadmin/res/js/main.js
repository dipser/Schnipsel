// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});
    while (length--) {
        method = methods[length];
        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());




$(function(){
	
	var $window = $(window),
		$html = $('html'),
		$body = $('body');
	
	
	
	// Scrollto
	$('a[href*=#]').on('click', function(e){
		e.preventDefault();
		var hash = $(this).attr('href');
		var dest = 0;
		if ($(hash).offset().top > $(document).height() - $(window).height()) {
			dest = $(document).height() - $(window).height();
		} else {
			dest = $(hash).offset().top;
		}
		// Animierung
		$('html,body').animate(
			{scrollTop:dest},
			{queue:false, duration:1000, easing:'easeInOutCubic'/*, complete: function () { location.href = hash; }*/}
		);
		// Update URL, sofern Unterstützung vorhanden
		if (window.history && window.history.pushState) {
			history.pushState("", document.title, id || null);
		}
	});
	
	
	
});

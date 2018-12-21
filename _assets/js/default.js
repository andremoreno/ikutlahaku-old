/* use jquery 1.12.4 */
//= require js/jquery.1.12.4.min.js
//= require js/bibleref.js
//= require js/contact.js
//= require js/jquery.stayInWebApp.js
//= require js/pace.js
//= require js/jquery.lazyloadxt.js
//= require js/jquery.lazyloadxt.widget.js

/*(function(document) {
	var toggle = document.querySelector('.sidebar-toggle');
	var sidebar = document.querySelector('#sidebar');
	var checkbox = document.querySelector('#sidebar-checkbox');

	document.addEventListener('click', function(e) {
		var target = e.target;
		
		if (!checkbox.checked || sidebar.contains(target) || (target === checkbox || target === toggle)) return;
		checkbox.checked = false;
	} false);
})(document);*/

(function(document) {
	var toggle = document.querySelector('.sidebar-toggle');
	var sidebar = document.querySelector('#sidebar');
	var checkbox = document.querySelector('#sidebar-checkbox');

	function toggleSidebar(e) {
		var target = e.target;
		if (!checkbox.checked || sidebar.contains(target) || (target === checkbox || target === toggle)) return;
		checkbox.checked = false;
	}

	document.addEventListener('click', toggleSidebar, false);
	document.addEventListener('touchstart', toggleSidebar, false);
})(document);


$(document).ready(function() {
	//Check to see if the window is top if not then display button
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('.iatop').fadeIn();
		} else {
			$('.iatop').fadeOut();
		}
	});

	//Click event to scroll to top
	$('.iatop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
});


jQuery(document).ready(function($) {
    $('a').not('[href*="mailto:"]').each(function () {
		var isInternalLink = new RegExp('/' + window.location.host + '/');
		if ( ! isInternalLink.test(this.href) ) {
			$(this).attr('target', '_blank');
		}
	});
});


(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function() {
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-53417403-1', 'auto');
ga('send', 'pageview');
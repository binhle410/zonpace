/**
 * PROFILE JS
 * 1. SHOW MENU MOBILE
 */
var profile_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. SHOW MENU MOBILE
 */
profile_fn.menuMobile = function () {
	if(!$('.prof-mb').length) { return; }
	var w_scroll_window = 0;
    if (navigator.appVersion.indexOf("Win")!=-1) {
        w_scroll_window = 20;
    }

    if(($(window).width() + w_scroll_window) < 767 ) {
		$('.prof-mb').on('click', function (e) {
			var $a_menu		=	$(this),
				$menu 		=	$a_menu.closest('.profile-mb-menu');

			if($a_menu.hasClass('active')) {
				$a_menu.removeClass('active');
				$menu.removeClass('shw');
			} else {
				$a_menu.addClass('active');
				$menu.addClass('shw');
			}
		});

		// $(".profile-mb-menu").bind( "clickoutside", function(event){
  //           $('.prof-mb').removeClass('active');
  //           $('.profile-mb-menu').removeClass('shw');
  //       });
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// menu
	profile_fn.menuMobile();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);

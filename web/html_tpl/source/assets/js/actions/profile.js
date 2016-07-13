/**
 * PROFILE JS
 * 1. SHOW MENU MOBILE
 * 2. VALIDATE FORM
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
	}
};
/**
 * 2. VALIDATE FORM
 */
profile_fn.validForm = {
	checkForm : function () {
		if (!$('.frm-my-account').length) {return;}
    	var $r_frm = $('.frm-my-account');

    	$r_frm.on('submit', function(e){
	        var errora = true;

	        if ($r_frm.find('.ipt').val() === '') {
	            $r_frm.find('.ipt').addClass('error');
	            errora = false;
	        }

	        if (!$r_frm.find('#ipt-email').val() || $r_frm.find('#ipt-email').val() === undefined || !profile_fn.validForm.validateEmail($r_frm.find('#ipt-email').val()) ) {
	            $r_frm.find('#ipt-email').addClass('error');
	            errora = false;
	        }

	        if (!errora) {
	            alert('Please confirm your infomation');

	            $('body').animate({
		            scrollTop: ($('.frm-my-account').position().top * -1)
		        },{
		            queue: false,
		            duration: 1000
		        });
	        }

	        return errora;
	    });

	    $r_frm.find('.ipt').on('focus', function(e){
	        $(this).removeClass('error');
	    });
	},
	validateEmail : function(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// menu
	profile_fn.menuMobile();

	// validate form
	profile_fn.validForm.checkForm();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);

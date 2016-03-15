/**
 * ALLPAGE JS
 * START - ONLOAD - JS
 * 1. Show more popular areas
 */
var homepage_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Show more popular areas
 */
homepage_fn.morePopular = {

	/**
	 * [description]
	 * @return {[type]} [description]
	 */
	show : () => {
		if(!$('.more a').length) { return; }

		$('.more a').on('click', function () {
			var $a_more		=	$(this),
				$list		=	$a_more.closest('.more').siblings('ol').find('li.li_hide');

			if($a_more.hasClass('active')) {
				$a_more.removeClass('active');
				$list.addClass('hide');
				$a_more.text('MORE +');
			} else {
				$a_more.addClass('active');
				$list.removeClass('hide');
				$a_more.text('LESS -');
			}
		});
	},

	checkList : () => {
		var $area_list = $('.blk-area-wrap .desc ol');
		
		$area_list.each(function (n,e) { 
			if($(this).find('li').length <= 5) {
				$(this).siblings('.more').addClass('hide');
			} 
		});
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// show more popular areas
	homepage_fn.morePopular.show();
	homepage_fn.morePopular.checkList();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);

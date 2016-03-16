/**
 * CATPAGE JS
 * 1. js layout masonry
 * 2. MAPs
 */
var catpage_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. js layout masonry
 */
catpage_fn.gridLayout = () => {
	if(!$('.grid-cate .grid-itm').length) { return; }

	$('.grid-cate').masonry({
		// set itemSelector so .grid-sizer is not used in layout
		itemSelector: '.grid-itm',
		percentPosition: true
	})
};
/**
 * MAPs
 */
catpage_fn.MAPs = {
	init: function () {
		var map = new google.maps.Map(document.getElementById('blk-map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8,
          scrollwheel: false,
        });
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// grid layout
	catpage_fn.gridLayout();

	// maps
	catpage_fn.MAPs.init();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);

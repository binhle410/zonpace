/**
 * LIST YOUR SPACE JS
 * 1. INIT MAP
 */
var listspace_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. INIT MAP
 */
listspace_fn.maps = {
	init: function () {
		var data_lat = $('#location_map').data('lat'),
			data_lng = $('#location_map').data('lng');
		var map = new google.maps.Map(document.getElementById('location_map'), {
          center: {lat: data_lat, lng: data_lng},
          zoom: 8,
          scrollwheel: false,
        });
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// maps
	listspace_fn.maps.init();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);

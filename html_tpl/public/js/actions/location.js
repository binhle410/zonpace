/**
 * CATPAGE JS
 * 1. MAPs
 */
var location_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. MAPs
 */
location_fn.MAPs = {
	init: function () {
		var map = new google.maps.Map(document.getElementById('location-map'), {
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

	// maps
	location_fn.MAPs.init();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);

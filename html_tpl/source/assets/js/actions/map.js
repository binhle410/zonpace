/**
 * MAP JS
 * 1. MAPs INIT
 */
var map_fn = {};
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. MAPs INIT
 */
map_fn.MAPs = {
	/**
	 * [init description]
	 * @return {[type]} [description]
	 */
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
	// MAPs INIT
	map_fn.MAPs.init();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;

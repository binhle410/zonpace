/**
 * HOMEPAGE JS
 * 1. Feature Slider
 */
var homepage_fn = {};
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Feature Slider
 */
homepage_fn.featureSlider = function (itmSlider) {
    if(!$(itmSlider).length) { return; }

    $(itmSlider).flexslider({
        animation: "slider",
        // Primary Controls
        controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
        slideshowSpeed: 4000,
        pauseOnHover: false,
        slideshow: true
    });
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){

    // Feature slider
    homepage_fn.featureSlider ('.feature-slider');
});
/* OnLoad Window */
$(window).load(function() {

});

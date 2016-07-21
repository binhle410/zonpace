/**
 * ALLPAGE JS
 * START - ONLOAD - JS
 * 1. Main slider
 * 2. Sticky header
 * 3. JS Select2
 * 4. Datetime picker
 * 5. Filter Ranger
 */
var allpage_fn = {};
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Main slider
 */
allpage_fn.mainSlider = function (itmSlider) {
    if(!$(itmSlider).length) { return; }

    $(itmSlider).flexslider({
        animation: "fade",
        // Primary Controls
        controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
        slideshowSpeed: 4000,
        pauseOnHover: false
    });
};
/**
 * 2. Sticky header
 */
allpage_fn.stickyHeader = function () {
    var body            =   $('body'),
        $header_wrap    =   $('.header-wrap'),
        offsetHeader    =   body.offset();

    $(window).scroll(function(){
        var scrollTop  = $(window).scrollTop();
        if(scrollTop > (offsetHeader.top + 100)){
            $header_wrap.addClass('hd-fixed');
        } else {
            $header_wrap.removeClass('hd-fixed');
        }
    });
};
/**
 * 3. JS Select2
 */
allpage_fn.jsSelect2 = function (itmSelect) {
    if(!$(itmSelect).length) { return; }

    $(itmSelect).select2();
};
/**
 * 4. Datetime picker
 */
allpage_fn.datePicker = function () {
    if(!$('.ipt-date').length) { return; }

    $('.ipt-date').each(function() {
        $(this).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    });
};
/**
 * 5. Filter Ranger
 */
allpage_fn.filterRanger = function (itmRanger) {
    if(!$(itmRanger).length) { return; }

    $(itmRanger).rangeSlider({
        wheelMode: "scroll",
        wheelSpeed: 30,
        bounds: {min: 0, max: 50},
        defaultValues:{min: 0, max: 20}
    });
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){

    // sticky header
    allpage_fn.stickyHeader ();

    // select 2
    allpage_fn.jsSelect2('.slect-lang');
    allpage_fn.jsSelect2('.slect-money');

    // datetime picker
    allpage_fn.datePicker();

    // filter ranger
    allpage_fn.filterRanger('#slider-ranger');
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;

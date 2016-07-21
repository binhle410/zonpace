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
            todayHighlight: true
        });
    });
};
/**
 * 5. Filter Ranger
 */
allpage_fn.filterRanger = function (itmRanger) {
    if(!$(itmRanger).length) { return; }

     $( itmRanger ).each(function () {
         var data_min = $(this).data('min'),
            data_max = $(this).data('max'),
            data_valmin = $(this).data('valmin'),
            data_valmax = $(this).data('valmax'),
            data_step = $(this).data('step');
         $(this).slider({
            range: true,
            min: data_min,
            max: data_max,
            values: [ data_valmin, data_valmax ],
            step: data_step,
            slide: function( event, ui ) {
                // original
                $(this).siblings('.f-num').text( $(this).slider( data_valmin ));
                $(this).siblings('.l-num').text( $(this).slider( data_valmax ));

                // after slider
                $(this).siblings('.f-num').text( $(this).slider( "values", 0 ));
                $(this).siblings('.l-num').text( $(this).slider( "values", 1 ) + "+");
            }
        });
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
    allpage_fn.filterRanger('#feet-slider');
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;

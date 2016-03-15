/**
 * ALLPAGE JS
 * START - ONLOAD - JS
 * 1. Main slider
 * 2. Sticky header
 * 3. JS Select2
 * 4. Datetime picker
 * 5. Filter Ranger
 * 6. Show Menu Mobile
 */
var allpage_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Main slider
 */
allpage_fn.mainSlider = (itmSlider) => {
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
    //if(!$('.input-daterange').length) { return; }

    $('.input-daterange input').each(function() {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
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
        defaultValues:{min: 0, max: 20},
        // formatter:function(val){
        //     var value = Math.round(val * 5) / 5,
        //     decimal = value - Math.round(val);
        //     return decimal == 0 ? "$" + value.toString() : value.toString();
        // }
    });
};
/**
 * 6. Show Menu Mobile
 */
allpage_fn.showMenuMB = () => {
    if(!$('.a_menu').length) { return; }

    $('.a_menu').on('click', function () {
        var $a_menu     =   $(this),
            $menu       =   $a_menu.closest('.header-logo').siblings('.header-menu');

        if($a_menu.hasClass('active')) {
            $a_menu.removeClass('active');
            $menu.hide();
        } else {
            $a_menu.addClass('active');
            $menu.show();
        }
    });

    // click out

    $(".header-wrap").bind( "clickoutside", function(event){
        $('.a_menu').removeClass('active');
        $('.header-menu').hide();
    });
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
    // Main slider
    allpage_fn.mainSlider ('.main-slider');

    // sticky header
    allpage_fn.stickyHeader ();

    // select 2
    allpage_fn.jsSelect2('.slect-lang');
    allpage_fn.jsSelect2('.slect-money');

    // datetime picker
    allpage_fn.datePicker();

    // filter ranger
    allpage_fn.filterRanger('#slider-ranger');

    // menu mobile
    allpage_fn.showMenuMB();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);

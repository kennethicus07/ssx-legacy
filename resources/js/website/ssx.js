$(document).ready(function() {

    $('#nav-search').on('click tap', function() {
        $('.searchbox_container').toggleClass('active');
    });

    // var isMobile = {
    //     Android: function() {
    //         return navigator.userAgent.match(/Android/i);
    //     },
    //     BlackBerry: function() {
    //         return navigator.userAgent.match(/BlackBerry/i);
    //     },
    //     iOS: function() {
    //         return navigator.userAgent.match(/iPhone/i);
    //     },
    //     Opera: function() {
    //         return navigator.userAgent.match(/Opera Mini/i);
    //     },
    //     Windows: function() {
    //         return navigator.userAgent.match(/IEMobile/i);
    //     }
    // };
    // var any = (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    // var isiPad = /ipad/i.test(navigator.userAgent.toLowerCase());
    // const mq = window.matchMedia("(min-width: 980px)");
    // const mq2 = window.matchMedia("(max-width: 767px)");

    // var ispage = '';

    // $('#login_btn').on('tap click', function(e) {
    //     e.preventDefault();
    //     hideAllPopup();
    //     var target = $(this).attr('data-target');
    //     $('.popup-container').addClass('active');
    //     $('.popup-container .' + target + '-holder').show();

    // });

    // $('#show_terms').on('tap click', function(e) {
    //     e.preventDefault();
    //     hideAllPopup();
    //     var target = $(this).attr('data-target');
    //     $('.popup-container').addClass('active');
    //     $('.popup-container .' + target + '-holder').show();

    // });

    // function hideAllPopup() {
    //     $('.popup-container').removeClass('active');
    //     $('.popup-container .popup > div').hide();
    // }

    // $('.popup-container .close_btn').on('click tap', function() {
    //     hideAllPopup();
    // });

    // $(window).on('load', function() {
    //     if (any) {
    //         $('#articleSlider').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider2').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider3').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider4').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider5').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });

    //     } else if (isiPad) {
    //         $('#articleSlider').lightSlider({
    //             item: 3,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider').lightSlider({
    //             item: 3,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider2').lightSlider({
    //             item: 3,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider3').lightSlider({
    //             item: 3,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider4').lightSlider({
    //             item: 3,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider5').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });
    //     } else {
    //         $('#articleSlider').lightSlider({
    //             item: 4,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider').lightSlider({
    //             item: 4,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider2').lightSlider({
    //             item: 4,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider3').lightSlider({
    //             item: 4,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider4').lightSlider({
    //             item: 4,
    //             pager: false,
    //             controls: true
    //         });

    //         $('#eventSlider5').lightSlider({
    //             item: 2,
    //             pager: false,
    //             controls: true
    //         });
    //     }
    // });
});
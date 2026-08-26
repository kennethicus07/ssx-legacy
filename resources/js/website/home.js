$(document).ready(function() {
    $("#latest-news").owlCarousel({
        loop: true,
        dots: true,
        lazyLoad: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });

    $("#eventSlider").owlCarousel({
        loop: true,
        dots: true,
        margin: 10,
        lazyLoad: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });
});
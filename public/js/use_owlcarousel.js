$(function() {
    $("#background").owlCarousel({
        loop: true,
        items: 1,
        smartSpeed: 1000,
        autoHeight: false,
        autoplayTimeout: 3000,
        autoplay: true,
        lazyLoad: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dotsEach: true
            },
            600: {
                items: 1,
                nav: true
            }
        }
    });

    $("#related-products").owlCarousel({
        loop: true,
        items: 4,
        autoplayTimeout: 3000,
        smartSpeed: 500,
        autoHeight: false,
        autoplay: true,
        lazyLoad: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            414: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    $("#best-seller").owlCarousel({
        loop: true,
        items: 4,
        autoplayTimeout: 3000,
        smartSpeed: 600,
        autoHeight: false,
        autoplay: true,
        lazyLoad: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            414: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    $("#new-arrivals").owlCarousel({
        loop: true,
        items: 4,
        autoplayTimeout: 4000,
        smartSpeed: 500,
        autoHeight: false,
        autoplay: true,
        lazyLoad: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            414: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    $("#hot-sales").owlCarousel({
        loop: true,
        items: 4,
        autoplayTimeout: 5000,
        smartSpeed: 500,
        autoHeight: false,
        autoplay: true,
        lazyLoad: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            414: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    $("#tab_image").owlCarousel({
        loop: false,
        items: 4,
        autoplay: false,
        nav: true
    });
});

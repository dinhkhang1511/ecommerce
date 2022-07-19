"use strict";

(function($) {
    /*------------------
        Background Set
    --------------------*/
    $(".set-bg").each(function() {
        var bg = $(this).data("setbg");
        $(this).css("background-image", "url(" + bg + ")");
    });

    //Search Switch
    $(".search-switch").on("click", function() {
        $(".search-model").fadeIn(400);
    });

    $(".search-close-switch").on("click", function() {
        $(".search-model").fadeOut(400, function() {
            $("#search-input").val("");
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true
    });

    /*------------------
        Accordin Active
    --------------------*/
    $(".collapse").on("shown.bs.collapse", function() {
        $(this)
            .prev()
            .addClass("active");
    });

    $(".collapse").on("hidden.bs.collapse", function() {
        $(this)
            .prev()
            .removeClass("active");
    });

    //Canvas Menu
    var check = false;
    $(".canvas__open").on("click", function() {
        if (!check) {
            $(".offcanvas-menu-wrapper").addClass("active");
        } else {
            $(".offcanvas-menu-wrapper").removeClass("active");
        }
        check = !check;
    });

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*-------------------
		Radio Btn
	--------------------- */
    $(
        ".product__color__select label, .product__details__option__size label"
    ).on("click", function() {
        $(
            ".product__color__select label, .product__details__option__size label"
        ).removeClass("active");
        $(this).addClass("active");
    });

    /*-------------------
		Scroll
	--------------------- */
    $(".nice-scroll").niceScroll({
        cursorcolor: "#0d0d0d",
        cursorwidth: "5px",
        background: "#e5e5e5",
        cursorborder: "",
        autohidemode: true,
        horizrailenabled: false
    });

    /*------------------
		Magnific
	--------------------*/
    $(".video-popup").magnificPopup({
        type: "iframe"
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
    proQty.on("click", ".qtybtn", function() {
        var $button = $(this);
        var oldValue = $button
            .parent()
            .find("input")
            .val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button
            .parent()
            .find("input")
            .val(newVal);
    });

    var proQty = $(".pro-qty-2");
    proQty.prepend('<span class="fa fa-angle-left dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-right inc qtybtn"></span>');
    proQty.on("click", ".qtybtn", function() {
        var $button = $(this);
        var oldValue = $button
            .parent()
            .find("input")
            .val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button
            .parent()
            .find("input")
            .val(newVal);
    });

    /*------------------
        Achieve Counter
    --------------------*/
    $(".cn_num").each(function() {
        $(this)
            .prop("Counter", 0)
            .animate(
                {
                    Counter: $(this).text()
                },
                {
                    duration: 4000,
                    easing: "swing",
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                }
            );
    });
})(jQuery);

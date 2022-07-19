function liveToastSuccess() {
    $("#liveToastSuccess")
        .empty()
        .html(
            "Operation successful" +
                '<button type="button" class="close" id="close_success">' +
                '<span aria-hidden="true">&times;</span>' +
                "</button>"
        )
        .show();
    $("#liveToastSuccess")
        .delay(1000)
        .slideUp(200, function() {
            $(this).hide();
        });
}

function updateCart(that, qty) {
    $.ajax({
        url:
            "/update-cart-ajax?product=" +
            that
                .parents("tr")
                .find("#product_id")
                .val() +
            "&key=" +
            that
                .parents("tr")
                .find("#indexValue")
                .val() +
            "&quantity=" +
            qty,
        type: "get",
        dataType: "JSON",
        success: function(data) {
            liveToastSuccess();
            $("#total_price").text(
                data.toLocaleString("en", {
                    style: "currency",
                    currency: "USD"
                })
            );
        }
    });
}

$(".increase").on("click", function() {
    let quantity = parseInt(
        $(this)
            .siblings(".quantityValue")
            .val()
    );
    let max_qty = parseInt(
        $(this)
            .siblings("#max_qty")
            .val()
    );
    if (quantity + 1 <= max_qty) {
        $(this)
            .siblings(".quantityValue")
            .val(quantity + 1);
        var price =
            (quantity + 1) *
            parseFloat(
                $(this)
                    .parents("tr")
                    .find("#price_after_discount")
                    .val()
            );
        $(this)
            .parents("tr")
            .children(".cart__price")
            .text(
                price.toLocaleString("en", {
                    style: "currency",
                    currency: "USD"
                })
            );
        updateCart($(this), quantity + 1);
    }
});

$(".decrease").on("click", function() {
    let quantity = parseInt(
        $(this)
            .siblings(".quantityValue")
            .val()
    );
    if (quantity - 1 > 0) {
        $(this)
            .siblings(".quantityValue")
            .val(quantity - 1);
        var price =
            (quantity - 1) *
            parseFloat(
                $(this)
                    .parents("tr")
                    .find("#price_after_discount")
                    .val()
            );
        $(this)
            .parents("tr")
            .children(".cart__price")
            .text(
                price.toLocaleString("en", {
                    style: "currency",
                    currency: "USD"
                })
            );
        updateCart($(this), quantity - 1);
    }
});

$(".quantityValue").on("keyup", function() {
    let max_qty = parseInt(
        $(this)
            .siblings("#max_qty")
            .val()
    );
    let qty = parseInt($(this).val());
    $("#updateBtn").removeAttr("disabled");
    if (
        isNaN($(this).val()) ||
        parseInt($(this).val()) > max_qty ||
        parseInt($(this).val()) <= 0
    ) {
        $(this).val(1);
    } else {
        if ($(this).val() != "") {
            var price =
                qty *
                parseFloat(
                    $(this)
                        .parents("tr")
                        .find("#price_after_discount")
                        .val()
                );
            $(this)
                .parents("tr")
                .children(".cart__price")
                .text(
                    price.toLocaleString("en", {
                        style: "currency",
                        currency: "USD"
                    })
                );
            updateCart($(this), qty);
        }
    }
});

$(".deleteBtn").on("click", function() {
    var t = $(this);
    // var cart_amount =
    //     parseInt($("#cart_amount").text()) -
    //     parseInt(
    //         t
    //             .parents("tr")
    //             .find(".quantityValue")
    //             .val()
    //     );
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url:
            "/cart/" +
            $(this)
                .parents("tr")
                .find("#product_id")
                .val() +
            "?index=" +
            $(this)
                .parents("tr")
                .find("#indexValue")
                .val(),
        type: "delete",
        dataType: "JSON",
        success: function() {
            t.parents("tr").remove();
            // $("#cart_amount").text(cart_amount);
            var price = 0;
            $("#total_price").text(
                price.toLocaleString("en", {
                    style: "currency",
                    currency: "USD"
                })
            );
            liveToastSuccess();
        }
    });
});

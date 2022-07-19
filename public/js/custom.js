$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$("#province").on("change", function() {
    $.ajax({
        url: "/districts/" + $("#province").val(),
        type: "get",
        success: function(data) {
            $("#district ~ .nice-select .current").text("Select District");
            $("#district ~ .nice-select .list").empty();
            $("#district").empty();
            data.forEach(function(item) {
                $("#district ~ .nice-select .list").append(
                    "<li data-value='" +
                        item.id +
                        "' class='option'>" +
                        item.name +
                        "</li>"
                );
                $("#district").append(
                    "<option value='" + item.id + "'>" + item.name + "</option>"
                );
            });
        }
    });
});

$("#district").on("change", function() {
    $.ajax({
        url: "/wards/" + $("#district").val(),
        type: "get",
        success: function(data) {
            $("#ward ~ .nice-select .list").empty();
            $("#ward").empty();
            data.forEach(function(item) {
                $("#ward ~ .nice-select .current").text("Select Ward");
                $("#ward ~ .nice-select .list").append(
                    '<li data-value="' +
                        item.id +
                        '" class="option">' +
                        item.name +
                        "</li>"
                );
                $("#ward").append(
                    "<option value='" + item.id + "'>" + item.name + "</option>"
                );
            });
        }
    });
});

var btn = $("#button");

$(window).on("scroll", function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass("show");
    } else {
        btn.removeClass("show");
    }
});

btn.on("click", function(e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
});

$(document).on("click", "#close_success", function() {
    $("#liveToastSuccess").hide();
});

$("#apply_promos").on("click", function() {
    $("#apply_promos").html(
        '<div class="spinner-border spinner-border-sm" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>"
    );
    $.ajax({
        url: "/find-promos/" + $("#promos_code").val(),
        type: "get",
        success: function(data) {
            $("#apply_promos").html("APPLY");
            $("#price").val($("#old_price").val());
            if (data) {
                let total =
                    parseFloat($("#price").val()) *
                    ((100 - parseFloat(data.discount)) / 100);
                $("#price").val(total);
                $("#discount").val(data.discount);
                $("#apply_promos").html("APPLIED");
                $("#order_discount").text(data.discount + "%");
                $("#order_total").text(
                    total.toLocaleString("en", {
                        style: "currency",
                        currency: "USD"
                    })
                );
                $("#liveToastSuccess").html(
                    "Promo code found" +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        "</button>"
                );
                $("#liveToastSuccess").show();
                $("#liveToastSuccess")
                    .delay(1000)
                    .slideUp(200, function() {
                        $(this).hide();
                    });
                updatePaypalBtn(total);
                return;
            }
            $("#discount").val(0);
            $("#order_discount").text("0%");
            $("#order_total").text(
                parseFloat($("#old_price").val()).toLocaleString("en", {
                    style: "currency",
                    currency: "USD"
                })
            );
            $("#promos_code").val("");
            $("#liveToastError").html(
                "Promo code not found" +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    "</button>"
            );
            $("#liveToastError").show();
            $("#liveToastError")
                .delay(1000)
                .slideUp(200, function() {
                    $(this).hide();
                });
            updatePaypalBtn($("#old_price").val());
        }
    });
});

function updatePaypalBtn(total) {
    paypal.Button.render(
        {
            // Configure environment
            env: "sandbox",
            client: {
                sandbox:
                    "ARtU3c6GkSq_b4FqZGE0_2Sb2VCiOj4wjbyg3_m2CjeFzJaYnCraR8Qe8Bzcc0eN-uRBeFHzzv1TeZ7k",
                production: "demo_production_client_id"
            },
            // Customize button (optional)
            locale: "en_US",
            style: {
                size: "responsive",
                color: "black",
                shape: "rect",
                tagline: false
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: {
                                    total: Math.round(total * 100) / 100,
                                    currency: "USD"
                                }
                            }
                        ]
                    },
                    experience: {
                        input_fields: {
                            no_shipping: 1
                        }
                    }
                });
            },
            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment
                    .execute()
                    .then(function() {
                        $.ajax({
                            url: "/paypal-paid",
                            type: "get",
                            dataType: "JSON"
                        });
                    })
                    .then(function() {
                        $("#checkout-form").submit();
                    });
            }
        },
        "#paypal-button"
    );
    $("#paypal-button > div")
        .get(0)
        .remove();
}

$(document).on("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
    }
});

$("#login_as_admin").on("click", function() {
    if ($("#login_as_admin").is(":checked")) {
        $("input[name='email']").val("thanhphu2410@gmail.com");
        $("input[name='password']").val("123456");
    } else {
        $("input[name='email']").val("");
        $("input[name='password']").val("");
    }
});

$("#paypal").on("click", function() {
    if ($("#paypal").is(":checked")) {
        $("#site-btn").css("display", "none");
        if ($("#paypal-button > div").length == 0) {
            paypal.Button.render(
                {
                    // Configure environment
                    env: "sandbox",
                    client: {
                        sandbox:
                            "ARtU3c6GkSq_b4FqZGE0_2Sb2VCiOj4wjbyg3_m2CjeFzJaYnCraR8Qe8Bzcc0eN-uRBeFHzzv1TeZ7k",
                        production: "demo_production_client_id"
                    },
                    // Customize button (optional)
                    locale: "en_US",
                    style: {
                        size: "responsive",
                        color: "black",
                        shape: "rect",
                        tagline: false
                    },

                    // Enable Pay Now checkout flow (optional)
                    commit: true,

                    // Set up a payment
                    payment: function(data, actions) {
                        return actions.payment.create({
                            payment: {
                                transactions: [
                                    {
                                        amount: {
                                            total:
                                                Math.round(
                                                    $("#old_price").val() * 100
                                                ) / 100,
                                            currency: "USD"
                                        }
                                    }
                                ]
                            },
                            experience: {
                                input_fields: {
                                    no_shipping: 1
                                }
                            }
                        });
                    },
                    // Execute the payment
                    onAuthorize: function(data, actions) {
                        return actions.payment
                            .execute()
                            .then(function() {
                                $.ajax({
                                    url: "/paypal-paid",
                                    type: "get",
                                    dataType: "JSON"
                                });
                            })
                            .then(function() {
                                $("#checkout-form").submit();
                            });
                    }
                },
                "#paypal-button"
            );
        }
        $("#paypal-button").css("display", "block");
    }
});

$("#cod").on("click", function() {
    if ($("#cod").is(":checked")) {
        $("#site-btn").css("display", "block");
        $("#paypal-button").css("display", "none");
    }
});

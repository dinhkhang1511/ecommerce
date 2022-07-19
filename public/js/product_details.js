$(".tab-image").on("click", function() {
    var path = $(this)
        .find("input")
        .val();
    $("#main-image").attr("src", path);
    $("#main-image-link").attr("href", path);
    $(".tab-image").removeClass("active");
    $(this).addClass("active");
});

$("#review").on("keyup", function() {
    $("#reviewBtn").removeAttr("disabled");
    if (this.value == "") {
        $("#reviewBtn").attr("disabled", "disabled");
    }
});

function readURL(input) {
    $(".image-review").remove();
    for (let index = 0; index < input.files.length; index++) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $(".modal-body").append(
                '<img class="image-review mr-2" src="' +
                    e.target.result +
                    '" width="64" height="44" />'
            );
        };

        // convert to base64 string
        reader.readAsDataURL(input.files[index]);
    }
}

$("#imgInp").on("change", function() {
    readURL(this);
});

$("#increase").on("click", function() {
    let quantity = parseInt($("#quantity").val());
    let max_qty = parseInt($("#max_qty").val());
    if (quantity + 1 <= max_qty) {
        $("#quantity").val(quantity + 1);
        if (quantity + 1 > 0 && quantity + 1 <= max_qty) {
            $("#addToCartBtn").removeAttr("disabled");
        }
    }
});

$("#decrease").on("click", function() {
    let max_qty = parseInt($("#max_qty").val());
    let quantity = parseInt($("#quantity").val());
    if (quantity - 1 > 0) {
        $("#quantity").val(quantity - 1);
        if (quantity - 1 > 0 && quantity - 1 <= max_qty) {
            $("#addToCartBtn").removeAttr("disabled");
        }
    }
});

$(".size").on("click", function() {
    $("#quantity").val(0);
    $("#addToCartBtn").attr("disabled", "disabled");
    $.ajax({
        url: "/get-colors/" + $("#product_id").val() + "/" + $(this).val(),
        type: "get",
        dataType: "JSON",
        success: function(data) {
            var colorsRender = "";
            var active = "";
            var checked = "";
            data.forEach(function(item, index) {
                active = index == 0 ? "active" : "";
                checked = index == 0 ? "checked" : "";
                colorsRender +=
                    '<label class="color ' +
                    active +
                    '" style="background: ' +
                    item.color.code +
                    '" id="color_id' +
                    item.id +
                    '">' +
                    '<input type="radio" name="color" ' +
                    'value="' +
                    item.color_id +
                    '" ' +
                    checked +
                    ">" +
                    '<i class="fas fa-check"></i>' +
                    "</label>";
            });
            $("#colorWrapper")
                .empty()
                .append("<span>Color:</span>" + colorsRender);

            var path = $("#attribute" + data[0].id).val();
            $("#main-image").attr("src", path);
            $("#main-image-link").attr("href", path);

            $("#max_qty").val(data[0].product_quantity);
            $("#in_stock")
                .empty()
                .append("<span>In stock:</span> " + data[0].product_quantity);
        }
    });
});

$(document).on("click", ".color", function(e) {
    e.preventDefault();
    $("#addToCartBtn").attr("disabled", "disabled");
    $(".color").removeClass("active");
    $(this).addClass("active");
    $(this)
        .find("input")
        .prop("checked", true);

    $.ajax({
        url:
            "/get-attribute?size=" +
            $("[name='size']:checked").val() +
            "&color=" +
            $("[name='color']:checked").val() +
            "&product=" +
            $("#product_id").val(),
        type: "get",
        dataType: "JSON",
        success: function(data) {
            $("#quantity").val(0);
            $("#max_qty").val(data.product_quantity);
            $("#in_stock")
                .empty()
                .append("<span>In stock:</span> " + data.product_quantity);
            var path = $("#attribute" + data.id).val();
            $("#main-image").attr("src", path);
            $("#main-image-link").attr("href", path);
        }
    });
});

$("#quantity").on("keyup", function() {
    let max_qty = parseInt($("#max_qty").val());
    let qty = parseInt($(this).val());
    $("#addToCartBtn").removeAttr("disabled");
    if (isNaN($("#quantity").val()) || qty > max_qty || qty < 0) {
        $("#addToCartBtn").attr("disabled", "disabled");
    }
});

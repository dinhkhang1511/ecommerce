$(".category").on("click", function(e) {
    e.preventDefault();
    $(this).hasClass("active")
        ? $(this).removeClass("active")
        : $(this).addClass("active");
    var category_id = $(this)
        .children("#category_id")
        .val();
    var currentCategory = "category=" + $("#categorySelected").val();
    var splitCategory = $("#categorySelected")
        .val()
        .split(",");

    $("#categorySelected").val(
        $("#categorySelected").val() + category_id + ","
    );
    if (splitCategory.indexOf(category_id) != -1) {
        splitCategory.splice(splitCategory.indexOf(category_id), 1);
        $("#categorySelected").val(splitCategory);
    }

    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(
                currentCategory,
                "category=" + $("#categorySelected").val()
            );
        })
        .val();
    ajaxFilter();
});

$(".sub-category").on("click", function(e) {
    e.preventDefault();
    $(this).hasClass("active")
        ? $(this).removeClass("active")
        : $(this).addClass("active");
    var sub_category_id = $(this)
        .children("#sub_category_id")
        .val();
    var currentSubCategory = "subcategory=" + $("#subCategorySelected").val();
    var splitSubCategory = $("#subCategorySelected")
        .val()
        .split(",");

    $("#subCategorySelected").val(
        $("#subCategorySelected").val() + sub_category_id + ","
    );
    if (splitSubCategory.indexOf(sub_category_id) != -1) {
        splitSubCategory.splice(splitSubCategory.indexOf(sub_category_id), 1);
        $("#subCategorySelected").val(splitSubCategory);
    }

    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(
                currentSubCategory,
                "subcategory=" + $("#subCategorySelected").val()
            );
        })
        .val();
    ajaxFilter();
});

$(".onsale").on("click", function(e) {
    e.preventDefault();
    $(this).hasClass("active")
        ? $(this).removeClass("active")
        : $(this).addClass("active");
    var currentSale = "yes";
    var nextSale = "no";
    if ($(this).hasClass("active")) {
        currentSale = "no";
        nextSale = "yes";
    }
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace("sale=" + currentSale, "sale=" + nextSale);
        })
        .val();
    ajaxFilter();
});

$(".price").on("click", function(e) {
    e.preventDefault();
    $(this).hasClass("active")
        ? $(this).removeClass("active")
        : $(this).addClass("active");
    var price = $(this)
        .children("#price")
        .val();
    var currentPrice = "price=" + $("#priceSelected").val();
    var splitPrice = $("#priceSelected")
        .val()
        .split(",");

    $("#priceSelected").val($("#priceSelected").val() + price + ",");
    if (splitPrice.indexOf(price) != -1) {
        splitPrice.splice(splitPrice.indexOf(price), 1);
        $("#priceSelected").val(splitPrice);
    }

    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(
                currentPrice,
                "price=" + $("#priceSelected").val()
            );
        })
        .val();
    ajaxFilter();
});

$(".sizeFilter").on("click", function(e) {
    e.preventDefault();
    var parent = $(this).parent("label");
    parent.hasClass("active")
        ? parent.removeClass("active")
        : parent.addClass("active");
    var size_id = $(this).val();
    var currentSize = "size=" + $("#sizeSelected").val();
    var splitSize = $("#sizeSelected")
        .val()
        .split(",");

    $("#sizeSelected").val($("#sizeSelected").val() + size_id + ",");
    if (splitSize.indexOf(size_id) != -1) {
        splitSize.splice(splitSize.indexOf(size_id), 1);
        $("#sizeSelected").val(splitSize);
    }

    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(currentSize, "size=" + $("#sizeSelected").val());
        })
        .val();
    ajaxFilter();
});

$(".colorFilter").on("click", function(e) {
    e.preventDefault();
    var parent = $(this).parent("label");
    parent.hasClass("active")
        ? parent.removeClass("active")
        : parent.addClass("active");
    var color_id = $(this).val();
    var currentColor = "color=" + $("#colorSelected").val();
    var splitColor = $("#colorSelected")
        .val()
        .split(",");

    $("#colorSelected").val($("#colorSelected").val() + color_id + ",");
    if (splitColor.indexOf(color_id) != -1) {
        splitColor.splice(splitColor.indexOf(color_id), 1);
        $("#colorSelected").val(splitColor);
    }

    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(
                currentColor,
                "color=" + $("#colorSelected").val()
            );
        })
        .val();
    ajaxFilter();
});

$("#nameFilter").on("keyup", function(e) {
    e.preventDefault();
    var name = $(this).val();
    var currentUrl = $("#filterUrl").val();
    var currentName = currentUrl.slice(
        currentUrl.indexOf("name="),
        currentUrl.indexOf("&offset=")
    );
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(currentName, "name=" + name);
        })
        .val();
    ajaxFilter();
});

$("#sortby").on("change", function(e) {
    e.preventDefault();
    var sortby = $(this).val();
    var currentUrl = $("#filterUrl").val();
    var currentSortBy = currentUrl.slice(
        currentUrl.indexOf("sortby="),
        currentUrl.indexOf("&category=")
    );
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(currentSortBy, "sortby=" + sortby);
        })
        .val();
    ajaxFilter();
});

function ajaxFilter() {
    $("#spinner").css("display", "block");
    var currentUrl = $("#filterUrl").val();
    var currentOffset = currentUrl.slice(
        currentUrl.indexOf("offset=") + 7,
        currentUrl.indexOf("&limit=")
    );
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace("offset=" + currentOffset, "offset=0");
        })
        .val();

    var products = $(".product__hover input[name='product_id']");
    var currentLimit = parseInt(
        currentUrl.slice(currentUrl.indexOf("limit=") + 6, currentUrl.length)
    );
    var nextLimit = products.length < 5 ? 5 : products.length;
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace("limit=" + currentLimit, "limit=" + nextLimit);
        })
        .val();
    $.ajax({
        url: $("#filterUrl").val(),
        type: "get",
        success: function(data) {
            $("#products").empty();
            data.forEach(function(item) {
                renderProducts(item);
            });
            $(".shop__product__option__left p").text(
                "Showing " +
                    $(".product__hover input[name='product_id']").length +
                    " results"
            );
            $("#spinner").css("display", "none");
        }
    });
}

$("#shop_loadmore").on("click", function(e) {
    e.preventDefault();
    $("#shop_loadmore").html(
        '<div class="spinner-border spinner-border-sm" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>"
    );
    var check = false;
    var array = [];
    var products = $(".product__hover input[name='product_id']");
    for (let index = 0; index < products.length; index++) {
        array.push(parseInt(products.get(index).value));
    }

    var currentUrl = $("#filterUrl").val();
    var currentOffset = currentUrl.slice(
        currentUrl.indexOf("offset=") + 7,
        currentUrl.indexOf("&limit=")
    );
    $("#filterUrl")
        .val(function(i, v) {
            return v.replace(
                "offset=" + currentOffset,
                "offset=" + array.length
            );
        })
        .val();

    var currentLimit = parseInt(
        currentUrl.slice(currentUrl.indexOf("limit=") + 6, currentUrl.length)
    );
    if (currentLimit < 5) {
        $("#filterUrl")
            .val(function(i, v) {
                return v.replace("limit=" + currentLimit, "limit=5");
            })
            .val();
    }
    $.ajax({
        url: $("#filterUrl").val(),
        type: "get",
        success: function(data) {
            data.forEach(function(item) {
                if (array.indexOf(item.id) == -1) {
                    check = true;
                    renderProducts(item);
                }
            });
            if (data.length > 0 && check) {
                var currentLimit = currentUrl.slice(
                    currentUrl.indexOf("limit=") + 6,
                    currentUrl.length
                );
                var nextLimit = parseInt(currentLimit) + 5;
                $("#filterUrl")
                    .val(function(i, v) {
                        return v.replace(
                            "limit=" + currentLimit,
                            "limit=" + nextLimit
                        );
                    })
                    .val();
                $(".shop__product__option__left p").text(
                    "Showing " +
                        $(".product__hover input[name='product_id']").length +
                        " results"
                );
            }
            $("#shop_loadmore").text("Load More");
        }
    });
});

function renderProducts(item) {
    var price = parseInt(item.price).toLocaleString("en", {
        style: "currency",
        currency: "USD"
    });
    var discountRender = item.discount > 0 ? "<span>" + price + "</span>" : "";
    var saleRender = item.discount > 0 ? '<span class="label">Sale</span>' : "";
    var starRender = "";
    for (var i = 0; i < item.rating_star; i++)
        starRender += '<i class="fa fa-star"></i> ';

    for (var i = 5; i > item.rating_star; i--)
        starRender += '<i class="fa fa-star-o"></i> ';

    $("#products").append(
        '<div class="col-lg-4 col-md-6 col-6">' +
            '<div class="product__item sale">' +
            '<div class="product__item__pic set-bg" style="background-image: url(/' +
            item.first_image +
            ');">' +
            saleRender +
            '<ul class="product__hover">' +
            "<li>" +
            '<form action="/wishlist" method="post">' +
            '<input type="hidden" name="_token" value="' +
            $('meta[name="csrf-token"]').attr("content") +
            '">' +
            '<input type="hidden" value="' +
            item.id +
            '" name="product_id">' +
            '<button type="submit" class="wishlist">' +
            '<i class="fa fa-heart-o" aria-hidden="true"></i>' +
            "</button>" +
            "</form>" +
            "</li>" +
            " <li>" +
            '<a href="/product-details/' +
            item.id +
            '">' +
            '<button type="submit" class="wishlist">' +
            '<i class="fa fa-search"></i>' +
            "</button>" +
            "</a>" +
            "</li>" +
            "</ul>" +
            "</div>" +
            '<div class="product__item__text">' +
            "<h6>" +
            item.name +
            "</h6>" +
            '<a href="/product-details/' +
            item.id +
            '" class="add-cart">+ Add To Cart</a>' +
            '<div class="rating">' +
            starRender +
            "</div>" +
            '<h5 class="discount">' +
            item.after_discount.toLocaleString("en", {
                style: "currency",
                currency: "USD"
            }) +
            discountRender +
            "</h5>" +
            "</div>" +
            "</div>" +
            "</div>"
    );
}

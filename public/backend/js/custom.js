$("#summernote").summernote({
    placeholder: "Type something ...",
    tabsize: 2,
    height: 80,
    toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline", "clear"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["table", ["table"]]
        // ['insert', ['link', 'picture', 'video']],
    ]
});

$("#province").on("change", function() {
    $.ajax({
        url: "/districts/" + $("#province").val(),
        type: "get",
        success: function(data) {
            $("#district").empty();
            $("#district").empty();
            data.forEach(function(item) {
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
            $("#ward").empty();
            $("#ward").empty();
            data.forEach(function(item) {
                $("#ward").append(
                    "<option value='" + item.id + "'>" + item.name + "</option>"
                );
            });
        }
    });
});

$("#month").on("change", function() {
    $(location).attr("href", "/dashboard/?m=" + $("#month").val());
});

$(document).on("click", ".deleteAttribute", function(e) {
    e.preventDefault();
    var currentAttribute = parseInt($("#currentAttribute").val());
    if (currentAttribute - 1 >= 1) {
        $(this)
            .parents("tr")
            .remove();
        $("#currentAttribute").val(currentAttribute - 1);
    }
});

$("#addAttribute").on("click", function(e) {
    e.preventDefault();
    var maxOfAttribute = parseInt($("#maxOfAttribute").val());
    var currentAttribute = parseInt($("#currentAttribute").val());
    var sizes = document.getElementById('select-sizes');
    var colors = document.getElementById('select-colors');


            if (currentAttribute + 1 <= maxOfAttribute) {
                $("#attributeWrapper").append(
                    "<tr>" +
                        "<td>" +
                        sizes.outerHTML +
                        "</td>" +
                        "<td>" +
                        colors.outerHTML +
                        "</td>" +
                        "<td>" +
                        '<input type="number" class="form-control"' +
                        'placeholder="Enter Quantity" name="quantity[]" value="">' +
                        "</td>" +
                        "<td>" +
                        '<div class="custom-file">' +
                        '<input type="file" multiple class="custom-file-input"' +
                        'name="images' +
                        currentAttribute +
                        '[]" accept="image/*">' +
                        '<label class="custom-file-label">Choose images</label>' +
                        "</div>" +
                        "</td>" +
                        "<td>" +
                        '<button class="btn-none deleteAttribute" type="submit" data-toggle="tooltip"' +
                        'data-original-title="Delete">' +
                        '<i class="fa fa-close text-danger"></i>' +
                        "</button>" +
                        "</td>" +
                        "</tr>"
                );
                $("#currentAttribute").val(currentAttribute + 1);
            }
    });

$("#files").on("change", function() {
    $("#files ~ .custom-file-label").text(
        $(this).get(0).files.length + " files choose"
    );
});

$(".order_status").on("change", function() {
    var order_id = $(this).attr("data-id");
        // $(this)
        //     .parent("select")
        //     .siblings(".order_id").length > 0
        //     ? $(this)
        //           .parent("select")
        //           .siblings(".order_id")
        //           .val()
        //     : $(".order_id").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: "/updateOrder/" + order_id,
        type: "patch",
        data: {
            status: $(this).val()
        },
        success: function(data) {
            console.log(data);
            $.toast({
                heading: "Success",
                text: "Operation Success",
                position: "top-right",
                loaderBg: "#ff6849",
                icon: "success",
                hideAfter: 3500,
                stack: 6
            });
        },
        statusCode: {
            401: function() {
                window.location.replace("/logout");
            }
          }
    });
});

$("#search").on("keyup", function() {
    var $rows = $("#table tr");
    var val = $.trim($(this).val())
        .replace(/ +/g, " ")
        .toLowerCase();
    $rows
        .show()
        .filter(function() {
            var text = $(this)
                .text()
                .replace(/\s+/g, " ")
                .toLowerCase();
            if (text.indexOf(val) == -1) {
                return true;
            }
            return false;
            // return !~text.indexOf(val);
        })
        .hide();
});

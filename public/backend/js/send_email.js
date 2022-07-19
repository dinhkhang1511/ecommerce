$(".plus-btn").on("click", function(e) {
    e.preventDefault();
    $("#individual_wrapper").append(
        '<div class="form-group mb-3" id="emails_wrapper">' +
            "<label>" +
            "Email" +
            '<button class="icon-btn minus-btn" type="button">' +
            '<i class="fa fa-minus-circle"></i></button>' +
            "</label>" +
            '<input type="text" class="form-control" placeholder="Enter email" autocomplete="off"' +
            ' name="individual_emails[]">' +
            "</div>"
    );
});

$(document).on("click", ".minus-btn", function(e) {
    e.preventDefault();
    $(this)
        .parents("#emails_wrapper")
        .remove();
});

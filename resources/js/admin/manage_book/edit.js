const { default: Axios } = require("axios");

$(function() {
    $("#form-edit-book .btn-edit-book").on('click', function() {
        $("#form-edit-book").submit();
    });

    $("#form-edit-book .btn-delete-book").on('click', function() {
        let id = $("#form-edit-book input[name='book_id']").val();
        axios.delete(`/admin/book/${id}`).then(() => {
            window.location = '/admin/book';
        });
    })
});
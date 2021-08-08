$('.login-btn').on('click', function() {
    window.location.href = "/user/login";
})
$('.register-btn').on('click', function() {
    window.location.href = "/user/register";
})
$('.profile-btn').on('click', function() {
    window.location.href = "/user/profile";
})

$(document).ready(function() {
    if ($('.register input[name="success"]').val()) {
        $(".register #overlay").css({ "display": "block" });
        $(".register #popup").css({ "display": "block" });
        $(".register .form-box").css({ "display": "none" });
    }
})
$(document).ready(function() {
    if ($('input[name="success"]').val()) {
        $("#overlay").css({ "display": "block" });
        $("#popup").css({ "display": "block" });
    }
    $('.clearfix .submitbtn').on('click', function() {
        $("#overlay").css({ "display": "none" });
        $("#popup").css({ "display": "none" });
    })
})

$('.header__notify-header #readed').on('click', function() {
    let id = $(this).attr('attr-id');
    let data = {
        id: id
    }
    axios.post('/user/alert/readed', data).then(res => {
        if (res.data.success) {
            $('.header__notify-item').each(function(index) {
                $(this).addClass("bg-readed");
                $(this).removeClass("bg-not-read");
            })
            $('#count-alert').hide();
        } else {
            alert('Lỗi hệ thống, không thể thực hiện!');
        }
    }).catch(err => {
        alert('Lỗi hệ thống, không thể thực hiện!');
    })
});
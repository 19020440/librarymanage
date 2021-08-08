const { default: Axios } = require('axios');

require('./slider')
require('./scroll_smooth')
require('../book_interface/cart')

$(document).ready(function() {
    let url = window.location.href;
    if (url.indexOf('welcome') != -1) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#content").offset().top
        }, 0);
    }
    if ($('input[name="success"]').val()) {
        $("#overlay").css({ "display": "block" });
        $("#popup").css({ "display": "block" });
    }
    $('.clearfix .submitbtn').on('click', function() {
        $("#overlay").css({ "display": "none" });
        $("#popup").css({ "display": "none" });
    });
});

// nav li đổi active khi scroll từng element
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('.sec-act');
    const navLia = document.querySelectorAll('.nav li a')
    let current = '';
    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset + 200 >= sectionTop) {
            current = section.getAttribute('id');
        }
    })
    navLia.forEach((lia) => {
        lia.classList.remove('active');
        if (lia.classList.contains(current)) {
            lia.classList.add('active');
        }
    })
})

$('.select-filter-book').on('change', function() {
    if (this.value === "category") {
        $('.ddc-link').css('display', 'flex');
    } else {
        $('.ddc-link').hide();
    }
})

$(document).ready(function() {
    // element trượt lên khi scroll xuống => animation
    $(window).scroll(function() {
        $(".slideanim").each(function() {
            var pos = $(this).offset().top;
            var winTop = $(window).scrollTop();
            if (pos < winTop + 300) {
                $(this).addClass("slide");
            }
        });
    });

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
});

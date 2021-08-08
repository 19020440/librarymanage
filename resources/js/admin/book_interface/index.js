require('../welcome/scroll_smooth')
require('./cart')

$(document).ready(function() {
    if ($('input[name="success"]').val()) {
        $("#overlay").css({ "display": "block" });
        $("#popup").css({ "display": "block" });
    }
    $('.clearfix .submitbtn').on('click', function() {
        $("#overlay").css({ "display": "none" });
        $("#popup").css({ "display": "none" });
    });
    let bookQuantity = Number($("input[name='book_quantity']").val());
    if (bookQuantity > 5) {
        bookQuantity = 5;
    }
    $('.view-cart').click(function() {
        $('.cart-interface').show(500);
    })
    $('.book-btn-sub').click(function() {
        $('.book-num-input').val(parseInt($('.book-num-input').val()) - 1);
        if ($('.book-num-input').val() <= 1) {
            $('.book-num-input').val(1);
        }
    })
    $('.book-btn-add').click(function() {
        $('.book-num-input').val(parseInt($('.book-num-input').val()) + 1);
        if ($('.book-num-input').val() >= bookQuantity) {
            $('.book-num-input').val(bookQuantity);
        }
    })
    $('.book-num-input').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    $('.book-num-input').blur(function() {

        if ($(this).val() == "") {
            $(this).val(1);
        }
        if (parseInt($(this).val()) >= bookQuantity) {
            $(this).val(bookQuantity);
        }
        if (parseInt($(this).val()) <= 1) {
            $(this).val(1);
        }
    })

    let listImg = $('.list-img');
    let listImgMax = $('.list-img-max');
    let mainImg = $('.book-main-img img');
    let sliderMainImg = $('.slider-view-main img');

    function load(cur) {
        listImg.removeClass('active');
        listImgMax.removeClass('active');
        cur.addClass('active');
        mainImg.attr('src', cur.attr('src'));
        sliderMainImg.attr('src', cur.attr('src'));
    }
    listImg.each(function(index) {
        $(this).click(function() {
            load($(this));
            listImgMax[index].classList.add('active');
        })
    })
    listImgMax.each(function(index) {
        $(this).click(function() {
            load($(this));
            listImg[index].classList.add('active');
        })
    })

    $('.next').click(function() {
        let curIndex = listImgMax.index($('.list-img-max.active'));
        listImgMax.removeClass('active');
        curIndex += 1;
        if (curIndex >= listImgMax.length) {
            curIndex = 0;
        }
        load($(listImgMax[curIndex]));
        listImg[curIndex].classList.add('active');
    })
    $('.prev').click(function() {
        let curIndex = listImgMax.index($('.list-img-max.active'));
        listImgMax.removeClass('active');
        curIndex -= 1;
        if (curIndex < 0) {
            curIndex = listImgMax.length - 1;
        }
        load($(listImgMax[curIndex]));
        listImg[curIndex].classList.add('active');
    })

    mainImg.click(function() {
        $('.slider-view-img').fadeIn(500);
    })
    $('.close').click(function() {
        $('.slider-view-img').fadeOut(500);
    })
    $('.header__notify-header #readed').on('click', function() {
        let id = $(this).attr('attr-id');
        let data = {
            id: id
        }
        axios.post('/user/alert/readed', data).then(res => {
            if (res.data.success) {
                $('.header__notify-item').each(function() {
                    $(this).addClass("bg-readed");
                    $(this).removeClass("bg-not-read");
                })
                $('#count-alert').css('display', 'none');
            } else {
                alert('Lỗi hệ thống, không thể thực hiện!');
            }
        }).catch(err => {
            alert('Lỗi hệ thống, không thể thực hiện!');
        })
    });
});

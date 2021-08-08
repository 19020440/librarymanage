const { default: Axios } = require("axios");

$(document).ready(function() {
    $('.overlay').click(function() {
        $('.cart-interface').hide(500);
    })
    $('.cart-out').click(function() {
        $('.cart-interface').hide(500);
    })
    $('.nav-cart-view').click(function() {
        $('.cart-interface').show(500);
    })
    let arrNum = $('.cart-num')
    let listItemBig = $('.row-cart');
    let listItemSmall = $('.nav-cart-item');
    listItemBig.each(function(index, cur) {
        $(this).find('> * > * >.btn-add').click(function() {
            let bookQuantity = Number(($(this).find("#book_quantity")).val());
            if (bookQuantity > 5) {
                bookQuantity = 5;
            }
            let id = $(this).next().val();
            data = {
                id: id,
                type: 'add'
            }
            arrNum[index].value = parseInt(arrNum[index].value) + 1;
            if (arrNum[index].value > bookQuantity) {
                arrNum[index].value = bookQuantity;
            } else {
                axios.post('/user/changecart', data).then(res => {
                    if (res.data.success) {
                        $('.cart-interface .cart-info #sum-book').text(res.data.sumBook);
                        $('.nav-logged-in .nav-cart-notice').text(res.data.countCast);
                    }
                }).catch(err => {
                    alert('Lỗi hệ thống, không thể thực hiện!');
                });
            }

        })
        $(this).find('> * > * >.btn-sub').click(function() {
            let id = $(this).next().val();
            data = {
                id: id,
                type: 'sub'
            }
            axios.post('/user/changecart', data).then(res => {
                if (res.data.success) {
                    $('.cart-interface .cart-info #sum-book').text(res.data.sumBook);
                    $('.nav-logged-in .nav-cart-notice').text(res.data.countCast);
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            });
            arrNum[index].value = parseInt(arrNum[index].value) - 1;
            if (arrNum[index].value == 0) {
                $(this).parents('.row-cart').remove();
                listItemSmall[index].remove();
                isHollow();
            }
        })
        $(this).find('> * > * > .cart-num').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });
        $(this).find('> * > * > .cart-num').blur(function() {
            if ($(this).val() == "") {
                $(this).val(1);
                arrNum[index].value = 1;
            }
            if (parseInt($(this).val()) >= bookQuantity) {
                $(this).val(10);
                arrNum[index].value = bookQuantity;
            }
            if (parseInt($(this).val()) <= 1) {
                $(this).val(1);
                arrNum[index].value = 1;
            }
        })
        $(this).find('> * > .btn-remove').click(function() {
            let id = $(this).next().val();
            data = {
                id: id
            }
            axios.post('/user/deletecart', data).then(res => {
                if (res.data.success) {
                    $('.cart-interface .cart-info #sum-book').text(res.data.sumBook);
                    $('.nav-logged-in .nav-cart-notice').text(res.data.countCast);
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            });
            $(this).parents('.row-cart').remove();
            listItemSmall[index].remove();
            isHollow();
        })
    })

    listItemSmall.each(function(index) {
        $(this).find('> * > * > .nav-cart-item-remove').click(function() {
            let id = $(this).next().val();
            data = {
                id: id
            }
            axios.post('/user/deletecart', data).then(res => {
                if (res.data.success) {
                    $('.cart-interface .cart-info #sum-book').text(res.data.sumBook);
                    $('.nav-logged-in .nav-cart-notice').text(res.data.countCast);
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            });
            $(this).parents('.nav-cart-item').remove();
            listItemBig[index].remove();
            isHollow();
        });
    })

    function isHollow() {
        if ($('.nav-cart-list-item').children().length === 0) {
            $('.nav-cart-list-item').hide();
            $('.nav-cart-heading').hide();
            $('.nav-cart-view').hide();
            $('.nav-view-list').hide();
            $('.nav-no-cart').show();
            $('.your-cart .form').hide();
        } else {
            $('.nav-cart-list-item').show();
            $('.nav-cart-heading').show();
            $('.nav-cart-view').show();
            $('.nav-view-list').show();
            $('.nav-no-cart').hide();
        }
        if ($('.row-cart').length === 0) {
            $('.no-cart').show();
            $('.your-cart .form').hide();
            $('.cart-info').hide();
        } else {
            $('.no-cart').hide();
            $('.your-cart .form').show();
            $('.cart-info').show();
        }
    }
    var checkboxAddress = 0;
    $('.cart-interface .checkbox-address').on('change', function() {
        checkboxAddress++;
        let val = $(".cart-interface input[name='address-default']").val();
        if (checkboxAddress % 2) {
            $('.cart-interface .input-address input').removeAttr('readonly');
        } else {
            $('.cart-interface .input-address input').val(val);
            $('.cart-interface .input-address input').attr('readonly', 'readonly');
        }
    });
    let checkDate = function() {
        let today = new Date();
        let giveback = new Date($(('.date-giveback')).val());
        let tomorrow = new Date(today.setDate(today.getDate() + 1));
        if (tomorrow.getHours() > 6) {
            tomorrow.setHours(6);
        }
        if (giveback == "Invalid Date") {
            return false;
        }
        if (giveback.getTime() < tomorrow.getTime()) {
            $('.error-date').show();
            return false;
        } else {
            $('.error-date').hide();
            return true;
        }
    }
    $('.date-giveback').on('change', checkDate);
    $('.cart-submit').click(function() {
        let check = true;
        if ($('.address-receive').val() == '') {
            check = false;
            $('.error-address').show();
        } else {
            check = true;
            $('.error-address').hide();
        }
        if (!checkDate()) {
            check = false;
        }
        if (check == true) {
            $('.form')[0].submit();
        }
    })
});
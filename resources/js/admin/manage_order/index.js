const { default: Axios } = require("axios");

$(function() {
    $('#list-order .admin__order-button-edit').on('click', function() {
        let Parent = $(this).parent().parent().parent();
        let date = Parent.find("input");
        let saveButton = Parent.find('.admin__order-button-save')
        date.prop('disabled', false)
        $(this).css('display', 'none');
        saveButton.css('display', 'inline-block');
    })

    $('#list-order .admin__order-button-save').on('click', function() {
        let Parent = $(this).parent().parent().parent();
        let date = Parent.find("input");
        let id = $(this).attr('attr-order');
        let time_borrow = Parent.find("input[name='time_borrow']");
        let time_promise_pay = Parent.find("input[name='time_promise_pay']");
        let time_pay = Parent.find("input[name='time_pay']");
        let editButton = Parent.find('.admin__order-button-edit');
        date.prop('disabled', true)
        $(this).css('display', 'none');
        editButton.css('display', 'inline-block');
        let data = {
            id: id,
            time_borrow: time_borrow.val(),
            time_promise_pay: time_promise_pay.val(),
            time_pay: time_pay.val()
        }
        axios.post('/admin/order/edit', data).then(res => {
            if (res.data.success == '1') {
                alert('Cập nhật đơn thành công.');
                location.reload();
            } else if (res.data.success == '2') {
                alert('Thông tin cập nhật không hợp lệ');
                location.reload();
            } else {
                alert('Lỗi hệ thống, không thể thực hiện!');
                location.reload();
            }
        }).catch(err => {
            alert('Lỗi hệ thống, không thể thực hiện!');
        })
    })
    $('#list-order .background-notBorrow .btn_confirm').on('click', function() {
        let id = $(this).attr('attr-order');
        let type = 'one-to-three';
        let data = {
            id: id,
            type: type
        }
        axios.post('/admin/order/changestatus', data).then(res => {
            if (res.data.success) {
                let parent = $(this).closest('.admin__order-col');
                let background = parent.closest('.background-notBorrow');
                let statusText = background.find('.col-status');
                background.addClass('background-borrowed');
                background.removeClass('background-notBorrow');
                statusText.text('Đang mượn');
                parent.html('');
            } else {
                alert('Lỗi hệ thống, không thể thực hiện!');
            }
        }).catch(err => {
            alert('Lỗi hệ thống, không thể thực hiện!');
        })
    })

    var idOrderChoose = 0;
    var btnCancel = '';
    $('#list-order .admin__order-button-cancel').on('click', function() {
        idOrderChoose = $(this).attr('attr-order');
        btnCancel = $(this);
    });
    $('#exampleModalCancel .btn-cancel').on('click', function() {
        if (idOrderChoose && btnCancel) {
            let id = idOrderChoose;
            let type = 'cancel';
            let data = {
                id: id,
                type: type
            }
            axios.post('/admin/order/cancel', data).then(res => {
                if (res.data.success) {
                    let parent = btnCancel.closest('.admin__order-col');
                    let background = parent.closest('tr');
                    let statusText = background.find('.col-status');
                    background.addClass('background-cancel');
                    background.removeClass('background-borrowed');
                    background.removeClass('background-notBorrow');
                    statusText.text('Đã hủy');
                    parent.html('');
                } else {
                    alert('Lỗi hệ thống, không thể thực hiện!');
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            })
        }
    })

    var idOrderDel = 0;
    var btnDel = '';
    $('#list-order .admin__order-button-delete').on('click', function() {
        idOrderDel = $(this).attr('attr-order');
        btnDel = $(this);
    });
    $('#exampleModal .btn-delete').on('click', function() {
        if (idOrderDel && btnDel) {
            let id = idOrderDel;
            let data = {
                id: id
            }
            axios.post('/admin/order/delete', data).then(res => {
                if (res.data.success == '1') {
                    alert('Xóa đơn thành công.');
                    location.reload();
                } else {
                    alert('Lỗi hệ thống, không thể thực hiện!');
                    location.reload();
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            })
        }
    })

    var idOrderCancel = 0;
    var colOrderCancel = '';
    $('.open-modal-pay').on('click', function() {
        $('#modal-pay').show();
    })
    $('.background-notBorrow .open-modal-cancel').on('click', function() {
        $('#modal-cancel').show();
        idOrderCancel = $(this).attr('attr-id');
        colOrderCancel = $(this).closest('.background-notBorrow');
    });
    $('#modal-pay #btn-modal-pay').on('click', function() {
        $('#modal-pay').css('display', 'none');
    });
    $('#modal-cancel #btn-modal-cancel').on('click', function() {
        $('#modal-cancel').css('display', 'none');
    });
    $('#modal-cancel #submit-cancel').on('click', function() {
        if (idOrderCancel && colOrderCancel) {
            let data = {
                id: idOrderCancel
            }
            axios.post('/user/order/cancel', data).then(res => {
                if (res.data.success) {
                    colOrderCancel.addClass('background-cancel');
                    colOrderCancel.removeClass('background-notBorrow');
                    $('#modal-cancel').css('display', 'none');
                }
            }).catch(err => {
                alert('Lỗi hệ thống, không thể thực hiện!');
            })
        }
    });

    $('#form-filter-order input').on('change', function() {
        $('#form-filter-order').submit();
    });
    if ($('tbody').children().length === 0) {
        $('.orderbook__content-noOrder').show();
    } else {
        $('.orderbook__content-noOrder').hide();
    }
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
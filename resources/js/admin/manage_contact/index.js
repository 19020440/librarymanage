$(".row-tb .btn-readed").on('click', function() {
    let idContact = $(this).attr('attr-id');
    let backgroundContact = $(this).closest('tr');
    let handleText = backgroundContact.find('.admin__order-handle');
    let statusText = backgroundContact.find('.col-status');
    let data = {
        id: idContact
    }
    axios.post('/admin/contact/readed', data).then(res => {
        if (res.data.success) {
            backgroundContact.removeClass('background-notRead');
            backgroundContact.addClass('background-readed');
            handleText.html(`
            <div class="admin__order-handle" data-toggle="modal" data-target="#exampleModal"
                attr-id="{{ $contact->id }}">
                <span>Xóa</span>
            </div>`);
            statusText.text('Đã đọc');
        } else {
            alert('Lỗi hệ thống, không thể thực hiện!');
        }
    }).catch(err => {
        alert('Lỗi hệ thống, không thể thực hiện!');
    })
});

var idContact = 0;
$('.row-tb').on('click', function() {
    idContact = $(this).attr('attr-id');
});

$('#exampleModal .btn-delete').on('click', function() {
    $('#exampleModal').css('display', 'none');
    if (idContact) {
        let data = {
            id: idContact
        }
        axios.post('/admin/contact/delete', data).then(res => {
            if (res.data.success) {
                alert('Xóa thành công.');
                location.reload();
            } else {
                alert('Lỗi hệ thống, không thể thực hiện!');
            }
        }).catch(err => {
            alert('Lỗi hệ thống, không thể thực hiện!');
        })
    }
});
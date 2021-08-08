$(function() {
    $(".manageuser__content .btn-delete").on('click', function() {
        let id = $(this).attr('attr-id');
        axios.delete(`/admin/user/${id}`).then(res => {
            if (!res.data.success) {
                alert('Lỗi hệ thống, không thể thực hiện!');
            } else {
                location.reload();
            }
        }).catch(err => {
            alert('Lỗi hệ thống, không thể thực hiện!');
        })
    });
})
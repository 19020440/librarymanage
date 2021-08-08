$(".btn-upload").on('click', function() {
    let parent = $(this).closest('.form-upload');
    let input = parent.find("input[type='file']");
    let linkimg = parent.find('.link-img');
    let img = parent.find('img');
    let text = parent.find('.alert-upload');
    input.click();
    input.on('change', function() {
        let files = $(this)[0].files;
        var ftype = files[0].type;
        if (ftype == 'image/png' || ftype == 'image/gif' || ftype == 'image/jpeg' || ftype == 'image/pjpeg') {
            for (let index = 0; index < files.length; index++) {
                let file = files[index];
                let formData = new FormData();
                formData.append("file", file);

                axios.post('/upload', formData)
                    .then(res => {
                        linkimg.val(res.data.url);
                        img.attr('src', res.data.url);
                        img.removeClass('hidden');
                        text.text('');
                    }).catch(err => {
                        console.error({ err });
                    });
            }
        } else {
            text.text('*File tải lên không hợp lệ.');
            setTimeout(function() {
                text.text('');
            }, 3000);
        }
    });
});
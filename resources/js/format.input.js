$(function() {
    $(document).on("input", "input[data-type='currency']", function() {
        this.value = this.value.replace(/\D/g, '');
    });
})

$(function() {
    $("input[data-type='phone']").on({
        blur: function() {
            var val = Number($(this).val());
            if (val == 0) {
                $(this).val(val);
            } else if (!val || val < 0) {
                $(this).val('');
            } else {
                $(this).val('0' + val);
            }
        }
    });
})

$(function() {
    $("input[data-type='email']").keyup(function() {
        var form = $(this).closest('.input-group-item');
        var btnSubmit = form.find('.submit-btn');
        var that = form.next();
        var val = this.value;
        if (val) {
            var email = new RegExp("^[A-Za-z0-9][a-zA-Z0-9~!@#$%^&*\-_`.,\"\']*$");
            if (email.test(val)) {
                $(that).html('');
                btnSubmit.removeAttr("disabled");
            } else {
                $(that).text('*Email không hợp lệ.');
                btnSubmit.attr("disabled", true);
            }
        }
    });
})
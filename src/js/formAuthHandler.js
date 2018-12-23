$(function () {
    $('#authorizationForm').on('submit', function(e) {
        let isValidForm = false;
        const login = $('#adLog').val();
        const password = $('#adPass').val();
        const btnSbm = $('#SingIn');

        e.preventDefault();

        if ($.trim(login) === '' || $.trim(password) === '') {
            showThenHideMsg('Incorrect login or password');
        } else {
            isValidForm = true;
        }

        if (isValidForm) {
            $.post({
                url: 'Utils/AccessForAdmin.php',
                dataType: 'json',
                data: {
                    'adLog': login,
                    'adPass': password
                },
                beforeSend: function (data) {
                    btnSbm.attr('disabled', 'disabled');
                },
                success: function (data) {
                    if (data['result'] === 'error') {
                        showThenHideMsg(data['msg']);
                    } else {
                        $(location).attr('href', '/interlabs/src/');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    showThenHideMsg("Status: " + xhr.status + "<br>" + thrownError);
                },
                complete: function (data) {
                    btnSbm.prop('disabled', false);
                }
            });
        }
    });
});

function showThenHideMsg(msg) {
    $('#fieldMsg')
        .html(msg)
        .show()
        .delay(1500)
        .hide(600);
}
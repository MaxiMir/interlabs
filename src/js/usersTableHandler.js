$(function () {

    /**
     * handler: activate redactor
     */   
    $('#activateRedactor').on('click', function () { 
        activateRedactor();
	});


    /**
     * handler: deactivate redactor
     */
    $('#btnCancel').on('click', function () {
    	deactivateRedactor();
    	$('[data-orderby="user_pos"]').trigger('click');
    });
    

    /**
     * handler: save sort
     */
    $('#btnSort').on('click', function () {
        let ids = getIds();
        const btnSaveSort = $(this);

        $.post({
            url: 'Utils/SaveSort.php',
            dataType: 'json',
            data: {
                'ids': ids
            },
            beforeSend: function (data) {
                btnSaveSort.attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data['result'] === 'error') {
                    showModal(data['msg'], 'error');
                } else {
                    showModal("Sort saved");
                    initialSortIds = getIds();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showModal("Status: " + xhr.status + "<br>" + thrownError, 'error');
            }
        });
    });
    
    
    /**
     * handler: checkbox
     */   
    $('#allCheckboxes').on('click', function () {
    	const valuePropChecked = $(this).is(':checked') ? true : false;
    	
        $('#users_info input:checkbox').prop('checked', valuePropChecked);
    });

    $('#users_info-table').on('click', 'input:checkbox', function () {
        const countCheckbox = $('tbody :checkbox').length;
        const countCheckboxChecked = $('tbody :checkbox:checked').length;
        const valuePropChecked = (countCheckbox === countCheckboxChecked);
        const btnDel = $('#btnDel');

    	$('#allCheckboxes').prop('checked', valuePropChecked);
        
        if (countCheckboxChecked === 0) {
            btnDel.attr('disabled', 'disabled');
        } else {
            btnDel.prop('disabled', false);
        }
    });


    /**
     * handler: sort Fields
     */
    $('a[data-orderBy]').on('click', function () {
        const linkOrderBy = $(this);
        const orderBy = linkOrderBy.attr('data-orderBy');

        $.post({
            url: 'Utils/SortUsers.php',
            dataType: 'json',
            data: {
                'orderBy': orderBy
            },
            beforeSend: function (data) {
                deactivateRedactor();
            },
            success: function (data) {
                if (data['result'] === 'error') {
                    showThenHideMsg(data['msg'], 'error');
                } else {
                    $('thead a[class="btn disabled"]').removeClass('disabled');
                        linkOrderBy
                            .blur()
                            .addClass('disabled');
                    $('#users_info-table tbody').html(data['markup']);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showThenHideMsg("Status: " + xhr.status + "<br>" + thrownError, 'error');
            }
        });
    });


    /**
     * handler: change data
     */
    $('#users_info-table').on('click','a[data-object]', function () {
        const tr = $(this).closest('tr');
        const td = $(this).closest('td');
        const user_id = tr.attr('data-id');
        const column = $(this).attr('data-object');
        const span = $(this).next('span');
        const oldValue = span.text();
        const allRedIcons = $('a[data-object]');
        $(this).data({'user_id': user_id, 'column': column, 'oldValue': oldValue});
  
        span.fadeOut('fast');
        $(this).fadeOut('fast', function () {
        	allRedIcons.addClass('disabled');
            createRenameForm(td);
            td
                .find('input')
                .focus()
                .val('')
                .val(oldValue);
        });
    });

    $('#users_info-table').on('click', '.btn-ok, .btn-cancel', function () {
        const renameForm = $(this).closest('.input-group');
        const input = renameForm.find('input[type="text"]');
        const hiddenLink = renameForm.siblings('a[data-object]');
        const hiddenSpan = hiddenLink.next('span');
        const user_id = hiddenLink.data('user_id');
        const column = hiddenLink.data('column');
        const oldValue = hiddenLink.data('oldValue');
        const newValue = input.val();
        const btnClose = renameForm.find('.btn-cancel');
        const allRedIcons = $('a[data-object]');

        if ($(this).hasClass('btn-cancel')) {
            renameForm.remove();
            hiddenLink.add(hiddenSpan).show('fast');
            allRedIcons.removeClass('disabled');
        } else {
            if (newValue === oldValue) {
                btnClose.trigger('click');
            } else if ($.trim(newValue) === '') {
                showThenHideMsg('Incorrect value', 'error');
                btnClose.trigger('click');
            } else {
                $.post({
                    url: 'Utils/UpdateData.php',
                    dataType: 'json',
                    data: {
                        'column': column,
                        'newValue': newValue,
                        'user_id': user_id
                    },
                    success: function (data) {
                        if (data['result'] === 'error') {
                            showModal(data['msg'], 'error');
                        } else {
                            $.when($('#users_info-table tbody')
                                .html(data['markup'])
                            ).done(function () {
                                showModal('Data successfully changed');
                                $('a[data-action="rename"], input:checkbox').removeClass('d-none');
                            });
                        }
                    },
                    error: errorHandler = function () {
                        showModal('Error changing data', 'error');
                    }
                });
            }
        }
    });

    
    /**
     *  handler: modal "Add User"
     */
    $('#btnAdd').on('click', function () {
        if ($('#loader').is(':has(.bouncing-loader)')) {
            $('#loader').empty();
            $('#newUserForm').find('.modal-body-elements').show();
        }
        $('#newUserForm')[0].reset();
        $('#errorField').empty();
        $('#newUserForm button[type=submit]').prop('disabled', false);
        $('#newUser').modal('show');
    });

    $('#newUserForm input[type=text]').on('blur', function () {
        const inputVal = $(this).val();
        const errorField = $('#errorField');
        const btnSave = $('#newUser').find('button[type="submit"]');

        if ($.trim(inputVal) !== '') {
            errorField.text('');
            btnSave.prop('disabled', false);
        } else {
            errorField.text('Incorrect field filling');
            btnSave.attr('disabled', 'disabled');
        }
    });

    $('#newUserForm').on('submit', function (e) {
        const modalBodyElements = $('#newUserForm').find('.modal-body-elements');
        const user_fullName =  $('#user_fullName').val();
        const user_email = $('#user_email').val();
        const user_adress = $('#user_adress').val();
        const btnSbm = $('#newUserForm').find('button[type="submit"]');
        const btnClose = $('#newUserForm').find('button[data-dismiss="modal"]');

        e.preventDefault();

        $.post({
            url: 'Utils/CreateUser.php',
            dataType: 'json',
            data: {
                'user_fullName': user_fullName,
                'user_email': user_email,
                'user_adress': user_adress
            },
            beforeSend: function (data) {
                modalBodyElements.hide(100, function () {
                    generateLoader();
                    btnSbm.attr('disabled', 'disabled');
                });
            },
            success: function (data) {
                if (data['result'] === 'error') {
                    showModal(data['msg'], 'error');
                } else {
                    btnClose.trigger('click');
                    $.when($('#users_info-table tbody')
                        .html(data['markup'])
                    ).done(function () {
                        showModal('User "' + user_fullName + '" successfully created');
                        $('a[data-action="rename"], input:checkbox').removeClass('d-none');
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showModal("Status: " + xhr.status + "<br>" + thrownError, 'error');
            }
        }); 
    });


    /**
     * handler: button "Delete selected"
     */
    $('#btnDel').on('click', function () {
        const checked = [];
        const btnDel = $('#btnDel');

        $('input:checkbox:checked').not("#allCheckboxes").each(function () {
            checked.push($(this).val());
        });

        if (checked.length === 0) {
            showModal('Sampling error', 'error');
        } else {
            $.post({
                url: 'Utils/DeleteData.php',
                dataType: 'json',
                data: {
                    'ids': checked
                },
                beforeSend: function (data) {
                    btnDel.attr('disabled', 'disabled');
                },
                success: function (data) {
                    if (data['result'] === 'error') {
                        showModal(data['msg'], 'error');
                    } else {
                        $.when($('#users_info-table tbody')
                            .html(data['markup'])
                        ).done(function () {
                            showModal('Successfully deleted');
                            $('a[data-action="rename"], input:checkbox').removeClass('d-none');
                        });
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    showModal("Status: " + xhr.status + "<br>" + thrownError, 'error');
                },
                complete: function (data) {
                    btnDel.prop('disabled', false);
                }
            });
        }
    });


    /**
     * handler: scroll
     */
    $(window).scroll(function () {
        const isScrollUpExists = $('footer').is(':has(#scroll-up)');

        if ($(this).scrollTop() < 500 && isScrollUpExists) {
            $('#scroll-up').hide();
        } else {
            if (!isScrollUpExists) {
                generateScrollBlock();
            }
            $('#scroll-up').show();
        }
    });
});


function activateRedactor() {
    initialSortIds = getIds();   
	
    $isActiveBtnSaveSort = !$('[data-orderby="user_pos"]').hasClass('disabled');
    $('#activateRedactor').hide();
    $('a[data-orderby]')
        .addClass('disabled')
        .not('[data-orderby="user_pos"]')
        .removeClass('disabled')
        .fadeOut('fast');
    $('#controlPanel, input:checkbox, a[data-action="rename"]').removeClass('d-none');
    $('#users_info-table tbody').addClass('text-left');
    toggleSortableTable();
    if ($isActiveBtnSaveSort) {
        $('#btnSort').prop('disabled', false);
    }
}


function deactivateRedactor() {
    $('#activateRedactor, a[data-orderby]:not([data-orderby="user_pos"])').fadeIn(1000);
    $('#controlPanel, input:checkbox, [data-action="rename"]').addClass('d-none');
    $('input:checkbox').prop('checked', false);
    $('#users_info-table tbody').removeClass('text-left');
    $('#btnSort').attr('disabled', 'disabled');
    toggleSortableTable();
}


function toggleSortableTable() {
    const propDisabledVal = $('#controlPanel').hasClass('d-none');
    const usersTbody = $('#users_info-table tbody');

    usersTbody.sortable({
    	disabled: propDisabledVal,
        stop: function() {
            if (isSortChange()) {
                $('#btnSort').prop('disabled', false);
            } else {
                $('#btnSort').attr('disabled', 'disabled');
            }
        },
    	cancel: '.edit, .input-group'
    });

    if (!propDisabledVal) {
        usersTbody.disableSelection();
    }
}

function getIds() {
    const ids = [];

    $('tbody tr').each(function () {
        ids.push($(this).attr('data-id'));
    });

    return ids;
}

function isSortChange() {
    const currentSortId =  getIds();

    return JSON.stringify(initialSortIds) !==  JSON.stringify(currentSortId);
}


function showModal(msg, error = null) {
    const modalAnsServer = $('#answerServer');
    const headerBlock = modalAnsServer.find('.modal-header');
    const header = headerBlock.find('.modal-title');
    const headerText = error ? 'Error!' : 'Success';
    const pMsg = $('#aswerServerMsg');

    header.text(headerText);
    headerBlock.attr('class', function () {
        return error ? 'modal-header bg-danger' : 'modal-header bg-info';
    });
    pMsg.html(msg);
    modalAnsServer.modal('show');
}


function createRenameForm(where) {
    $('<div>', {
        class: 'input-group',
        append: $('<input>', {
            class: 'form-control',
            type: 'text',
            placeholder: 'Enter new value',
            value: '',
            autofocus: 'autofocus'
        })
            .add($('<div>', {
                class: 'input-group-append',
                append: $('<button>', {
                    type: 'submit',
                    class: 'btn btn-outline-secondary btn-ok',
                    text: 'OK'
                })
                    .add($('<button>', {
                        type: 'button',
                        class: 'btn btn-outline-secondary btn-cancel',
                        text: 'CANCEL'
                    }))
            }))
    }).appendTo(where);
}


function generateLoader() {
    $('<div>', {
        class: 'bouncing-loader',
        append: $('<div>')
                    .add($('<div>'))
                    .add($('<div>'))
                    .add($('<div>'))
    }).appendTo('#loader');
}


function generateScrollBlock() {
    $('<div>', {
        id: 'scroll-up',
        css: {
            width: 35,
            height: 35,
            position: 'fixed',
            right: '3%',
            bottom: '2%',
            opacity: 0.6,
            cursor: 'pointer'
        },
        on: {
            click: function () {
                $(window).scrollTop(0);
            },
            mouseenter: function () {
                $(this).css({ 'opacity': '1',
                    '-webkit-transform': 'scale(1.3)',
                    '-ms-transform': 'scale(1.3)',
                    'transform': 'scale(1.3)'
                });
            },
            mouseleave: function () {
                $(this).css({ 'opacity': '0.6',
                    '-webkit-transform': 'scale(1.0)',
                    '-ms-transform': 'scale(1.0)',
                    'transform': 'scale(1.0)'
                });
            }
        },
        append: $('<img>', {
            src: '/interlabs/src/css/img/up-arrow.png',
            alt: 'scroll up',
            title: 'scroll up',
            width: '35px'
        })
    }).appendTo('footer');
}

/**
 * Created by alius on 2015.12.31.
 */
var modalWindow;
$(document).ready(function () {
    modalWindow = new jBox('Modal', {
        width: 630,
        blockScroll: false, //Kad neflikerintu - palieka scroll
        title: 'Forma',
        fade: false,
        animation: false,
        overlay: true, //Modal langas
        ajax: {
            url: '',
            reload: true,
            type: "post",
            data: ''
        },
        draggable: 'title'
    });

    //$('.modalwin').each(function () {
    $(document).on('click', '.modalwin', function (e) {
        openModal(this);
        /*if ($(this).data('modal-action') == 'edit'){
         modalWindow.options.ajax.data = {
         'pk':$(this).data('modal-pk'),
         'fk_name': $(this).data('modal-fk_name') || pk_name,
         'fk': $(this).data('modal-fk') || pk,
         'client_id': client_id
         };
         } else {
         modalWindow.options.ajax.data = {
         'fk_name': $(this).data('modal-fk_name') || pk_name,
         'fk': $(this).data('modal-fk') || pk,
         'client_id': client_id
         };
         }
         modalWindow.options.ajax.url = $(this).data('modal-url');
         modalWindow.open();
         $('.jBox-content').css('width',$(this).data('modal-width'));
         modalWindow.setTitle($(this).data('modal-title'));*/
    });
    //});
    $('form:not(.skipValidator)').formValidation();
});

function openModal(obj) {
    if ($(obj).data('modal-action') == 'edit') {
        modalWindow.options.ajax.data = {
            //'pk': $(obj).data('modal-pk'),
            //'fk_name': $(obj).data('modal-fk_name') || pk_name,
            //'fk': $(obj).data('modal-fk') || pk,
            //'client_id': client_id
        };
    } else {
        modalWindow.options.ajax.data = {
            //'fk_name': $(obj).data('modal-fk_name') || pk_name,
            //'fk': $(obj).data('modal-fk') || pk,
            //'client_id': client_id
        };
    }
    modalWindow.options.ajax.url = $(obj).data('modal-url');
    modalWindow.open();
    $('.jBox-content').css('width', $(obj).data('modal-width'));
    modalWindow.setTitle($(obj).data('modal-title'));
}

function closeModal() {
    modalWindow.close();
}

function validateCombobox(form) {
    var isValid = true;

    form.find("input.combobox").each(function () {
        //comboCount++;
        if (!$(this).data('clear')) {
            var errorDiv = $('#' + $(this).prop('name') + '-error')[0],
                select2container = $(this).parent('div').find('div.select2-container');
            if ($(this).select2('val') == '') {
                if (typeof errorDiv == "undefined") {
                    if (select2container.css('display') != 'none') {
                        isValid = false;
                        $($(this).closest('div.form-group').find('label')[0]).addClass('hasErrorLabel');
                        $(this).closest('div.form-group').append('<label id="' + $(this).prop('name') + '-error" style="position:absolute;font-size:12px;"><span style="color: #b94a48;">Å is laukas yra privalomas</span></label>');
                        select2container.css('border', '2px solid #b94a48');
                    }
                } else {
                    isValid = false;
                }
            } else {
                if (typeof errorDiv != "undefined") {
                    errorDiv.remove();
                    select2container.css('border', '1px solid #aaa');
                    $($(this).closest('div.form-group').find('label')[0]).removeClass('hasErrorLabel');
                }
            }
        }
    });

    return isValid;
}

function submitForm(formSelector, callback, url) {
    var $form = $(formSelector),
        bv = $form.data('formValidation'),
        comboboxIsValid = validateCombobox($form);
    bv.resetForm();
    bv.validate();
    if (!bv.isValid()) {
        if ($form[0].hasChildNodes('.nav.nav-tabs')) {
            $form.find("input").each(function () {
                if (!bv.isValidField($(this))) {
                    $('a[href=#' + $(this).closest('.tab-pane:not(.active)').attr('id') + ']').tab('show');
                    return false;
                }
            });
        }
        return false;
    } else {
        if (!comboboxIsValid) {
            return false;
        }
        $('.modal-footer .btn').prop('disabled', 'disabled');
        //Jei nepaduotas url imam modal lango url
        if (!url) {
            url = modalWindow.options.ajax.url;
        }
        //Jei nepaduotas callbackas - vadinas jis bus tiesiog perkrovimas
        if (!callback) {
            callback = function () {
                location.reload();
            }
        }
        new jBox('Notice', {
            color: 'black',
            animation: 'zoomIn',
            title: 'Saugoma...',
            autoClose: 5000,
            stack: false,
            attributes: {x: 'right', y: 'bottom'},
            position: {x: 50, y: 50},
            content: 'Saugome...'
        });
        setTimeout(function () {
            $('.modal-footer .btn').prop('disabled', '');
        }, 6000);

        //Submitinam
        $.post(url, $form.serialize(), function (data) {
            if (data.success) {
                callback(data);
                new jBox('Notice', {
                    color: 'green',
                    animation: 'zoomIn',
                    title: 'Išsaugota',
                    autoClose: 3000,
                    stack: false,
                    attributes: {x: 'right', y: 'bottom'},
                    position: {x: 50, y: 50},
                    content: 'Sėkmingai išsaugota'
                });
                setTimeout(function () {
                    $('.modal-footer .btn').prop('disabled', '');
                }, 1000);
            } else {

                if (data.code == 601 || data.code == 602) {
                    new jBox('Confirm', {
                        overlay: true,
                        draggable: 'title',
                        outside: 'x',
                        zIndex: 11000,
                        title: 'Užimtumas',
                        content: data.msg,
                        confirmButton: 'Išsaugoti',
                        cancelButton: 'Atšaukti',
                        confirm: function () {

                            new jBox('Notice', {
                                color: 'black',
                                animation: 'zoomIn',
                                title: 'Saugoma...',
                                autoClose: 3000,
                                stack: false,
                                attributes: {x: 'right', y: 'bottom'},
                                position: {x: 50, y: 50},
                                content: 'Saugome...'
                            });

                            var newFormDate = $form.serialize();
                            if (data.code == 601)
                                newFormDate = $form.serialize() + '&ignoreClassroomOverlap=true';
                            if (data.code == 602)
                                newFormDate = $form.serialize() + '&ignoreSubclusterOverlap=true';

                            //Submitinam
                            $.post(url, newFormDate, function (data) {
                                if (data.success) {
                                    callback(data);
                                    new jBox('Notice', {
                                        color: 'green',
                                        animation: 'zoomIn',
                                        title: 'Išsaugota',
                                        autoClose: 3000,
                                        stack: false,
                                        attributes: {x: 'right', y: 'bottom'},
                                        position: {x: 50, y: 50},
                                        content: 'Sėkmingai išsaugota'
                                    });
                                    setTimeout(function () {
                                        $('.modal-footer .btn').prop('disabled', '');
                                    }, 1000);
                                } else {
                                    new jBox('Notice', {
                                        color: 'red',
                                        animation: 'zoomIn',
                                        title: 'Klaida',
                                        autoClose: 3000,
                                        stack: true,
                                        attributes: {x: 'right', y: 'bottom'},
                                        position: {x: 50, y: 50},
                                        content: data.msg || data.query_encoded
                                    });
                                    setTimeout(function () {
                                        $('.modal-footer .btn').prop('disabled', '');
                                    }, 0);
                                }
                            }, "json");
                        },
                        cancel: function () {
                        },
                        onCloseComplete: function () {
                            this.destroy();
                        },
                    }).open();
                    setTimeout(function () {
                        $('.modal-footer .btn').prop('disabled', '');
                    }, 0);
                } else {

                    new jBox('Notice', {
                        color: 'red',
                        animation: 'zoomIn',
                        title: 'Klaida',
                        autoClose: 3000,
                        stack: true,
                        attributes: {x: 'right', y: 'bottom'},
                        position: {x: 50, y: 50},
                        content: data.msg || data.query_encoded
                    });
                    setTimeout(function () {
                        $('.modal-footer .btn').prop('disabled', '');
                    }, 0);
                }
            }
        }, "json");
    }
}

function deleteRecord(baseUrl, table, pk_name, pk, callback, quiet) {
    if (!baseUrl || !table || !pk_name || !pk) {
        console.dir('Neteisinga kryptis į deleteRecord funkciją Reikia paduoti -> @baseUrl, @table, @pk_name, @pk, @callback(nebūtinas)');
        return;
    }
    if (!quiet) quiet = false;
    //Jei nepaduotas callbackas - vadinas jis bus tiesiog perkrovimas
    if (!callback) {
        callback = function () {
            location.reload();
        }
    }
    if (quiet == false) {
        bootbox.dialog({
            message: '<span style="font-weight:bold;">Ar tikrai norite ištrinti?</span>',
            buttons: {
                success: {
                    label: "Ištrinti",
                    className: "btn-success",
                    callback: function () {
                        new jBox('Notice', {
                            color: 'black',
                            animation: 'zoomIn',
                            title: 'Triname...',
                            autoClose: false,
                            stack: false,
                            attributes: {x: 'right', y: 'bottom'},
                            position: {x: 50, y: 50},
                            content: 'Triname...'
                        });
                        //Trinam
                        $.post(baseUrl + '/ajax/settings/actions/delete', {
                            /*TODO:change*/
                            table: table,
                            pk_name: pk_name,
                            pk: pk
                        }, function (data) {
                            if (data.success && !data.error) {
                                callback();
                                new jBox('Notice', {
                                    color: 'green',
                                    animation: 'zoomIn',
                                    title: 'Ištrinta',
                                    autoClose: 1000,
                                    stack: false,
                                    attributes: {x: 'right', y: 'bottom'},
                                    position: {x: 50, y: 50},
                                    content: 'Sėkmingai ištrinta'
                                });
                            } else {
                                new jBox('Notice', {
                                    color: 'red',
                                    animation: 'zoomIn',
                                    title: 'Klaida',
                                    autoClose: false,
                                    stack: false,
                                    attributes: {x: 'right', y: 'bottom'},
                                    position: {x: 50, y: 50},
                                    content: data.msg || data.query_encoded
                                });
                            }
                        }, "json");
                    }
                },
                main: {
                    label: "Atšaukti",
                    className: "btn-default",
                    callback: function () {
                    }
                }
            }
        });
    } else {
        $.post('/ajax/settings/actions/delete', {
            /*TODO:change*/
            table: table,
            pk_name: pk_name,
            pk: pk
        }, function (data) {
            if (data.success && !data.error) {
                callback();
                new jBox('Notice', {
                    color: 'green',
                    animation: 'zoomIn',
                    title: 'Ištrinta',
                    autoClose: 1000,
                    stack: false,
                    attributes: {x: 'right', y: 'bottom'},
                    position: {x: 50, y: 50},
                    content: 'Operacija atlikta sėkmingai'
                });
            } else {
                new jBox('Notice', {
                    color: 'red',
                    animation: 'zoomIn',
                    title: 'Klaida',
                    autoClose: false,
                    stack: false,
                    attributes: {x: 'right', y: 'bottom'},
                    position: {x: 50, y: 50},
                    content: data.msg || data.query_encoded
                });
            }
        }, "json");
    }
}

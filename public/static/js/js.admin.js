/**
 * Adds red astericks where input has attribute Required.
 */
function colorRequiredFormValidation() {
    $('form:not(.skipValidator)').formValidation({locale: 'lt_LT'});
    $('input[data-fv-notempty="true"]').closest('div.form-group').find('label').append('&nbsp;<span style="color:red;">*</span>');
    $('input[required]').closest('div.form-group').find('label').append('&nbsp;<span style="color:red;">*</span>');
    $('input.combobox:not([data-clear])').closest('div.form-group').find('label').append('&nbsp;<span style="color:red;">*</span>');
    $('select.select2:not([data-clear])').closest('div.form-group').find('label').append('&nbsp;<span style="color:red;">*</span>');
}

/**
 * In <Select multiple> doesn't require to hold CTRL key to bind multiple values.
 * With this items bind on mouse click.
 */
function noCtrlKeyForSelect() {
    window.onmousedown = function (e) {
        var el = e.target;
        if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
            e.preventDefault();

            // toggle selection
            if (el.hasAttribute('selected'))
                el.removeAttribute('selected');
            else
                el.setAttribute('selected', '');

            // hack to correct buggy behavior. TODO: fix
            var select = el.parentNode.cloneNode(true);
            el.parentNode.parentNode.replaceChild(select, el.parentNode);
        }
    }
}

$(document).ready(function () {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        clearBtn: true,
        language: "lt",
        multidate: true,
        daysOfWeekHighlighted: "0,6"
    });
});

function keep_alive() {
    http_request = new XMLHttpRequest();
    http_request.open('GET', window.location.href);
    http_request.send(null);
}
setInterval(keep_alive, 60000);  // send request every 1min
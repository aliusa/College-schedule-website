/**
 * Created by alius on 2016.01.16.
 */
$(document).ready(function () {

    function weekdays() {
        return ["Pr", "An", "Tr", "Kt", "Pn", "Št", "Sk"];
    }

    //$('tr.expandable-datatable').each(function () {
    // Add event listener for opening and closing details
    $('tr.expandable-datatable').on('click', function () {
        var table = $('#' + $(this).closest('table').prop('id')).DataTable();
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.toggleClass('shown');
        }
        else {
            $.ajax({
                // Gets url from datatable to fetch from data.
                url: tr.data('schedule-url'),
                success: function (result) {
                    tr.toggleClass('shown');
                    // Link for editing modal.
                    var modalLink = tr.data('modal-url');
                    var lectureLink = tr.data('lecture-url');

                    row.child(displaySubTable(result, modalLink, lectureLink)).show();
                }
            });
        }
    });
    // });


    /* Formatting function for row details - modify as you need */
    function displaySubTable(data, modalLink, lectureLink) {
        data = JSON.parse(data)[0];
        var table = '<table class="table table-hover table-condensed"><thead><tr>' +
            '<th>ID</th>' +
            '<th>Pradžios data</th>' +
            '<th>Pabaigos data</th>' +
            '<th>Dėstytojas</th>' +
            '<th>Dienos</th>' +
            '<th>Paskaitos</th>' +
            '<th>Veiksmai</th>' +
            '</tr></thead><tbody>';
        var length = data.length;
        for (var i = 0; i < length; i++) {
            dayStart = weekdays()[data[i].DateStartWeekday];
            dayEnd = weekdays()[data[i].DateEndWeekday];

            table += '<tr><td>' + data[i].id + '</td>';
            table += '<td>' + data[i].DateStart + '&nbsp;<span class="label label-default">' + dayStart + '</span></td>';
            table += '<td><date>' + data[i].DateEnd + '&nbsp;<span class="label label-default">' + dayEnd + '</span></td>';
            table += '<td>' + data[i].Professor + '</td>';
            table += '<td>';
            table += data[i].msg;
            if (data[i].IsMonday == 1)
                table += '&nbsp;<span class="label label-default">Pr</span>';
            if (data[i].IsTuesday == 1)
                table += '&nbsp;<span class="label label-default">An</span>';
            if (data[i].IsWedneday == 1)
                table += '&nbsp;<span class="label label-default">Tr</span>';
            if (data[i].IsThurday == 1)
                table += '&nbsp;<span class="label label-default">Kt</span>';
            if (data[i].IsFriday == 1)
                table += '&nbsp;<span class="label label-default">Pn</span>';
            if (data[i].IsSaturday == 1)
                table += '&nbsp;<span class="label label-default">Št</span>';
            if (data[i].IsSunday == 1)
                table += '&nbsp;<span class="label label-default">Sk</span>';
            if (data[i].IsChosen == 1)
                table += '&nbsp;<span class="label label-info">Pasirenkamasis</span>';
            table += '</td>';
            table += '<td>' + data[i].lecture_count + '</td>';
            table += '<td><a href="#" class="btn btn-xs btn-primary modalwin" data-modal-title="Paskaitos"' +
                ' data-modal-width="800px" data-modal-url="' + lectureLink + data[i].id + '">Peržiūrėti paskaitas</a>';
            table += '&nbsp;<a href="#" class="btn btn-xs btn-danger" role="button">Trinti</a>';
            table += '</td>';
            table += '</tr>';
        }

        table += '</tbody>';
        // Bottom heading.
        //table += '<tfoot><tr><th>ID</th><th>Data</th><th>Laikas</th><th>Dėstytojas</th><th>Audiorija</th><th>Komentarai</th><th></th></tr></tfoot>';
        table += '</table>';
        return table;
    }
});
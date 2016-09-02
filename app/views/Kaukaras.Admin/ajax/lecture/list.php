<!--@formatter:off-->
<a href="#" class="btn btn-xs btn-primary modalwin"
   data-modal-title="Paskaitos"  data-modal-width="800px"
   data-modal-url="{{ urlFor('ajax/lecture/add', {'id':lectures[0].RecurringTaskId}) }}">Pridėti paskaitą</a>
<table class="table table-bordered table-striped table-hover table-condensed" id="lecture_list" >
    <thead>
        <tr>
            <th>ID</th>
            <th>Diena</th>
            <th>Pradžia</th>
            <th>Pabaiga</th>
            <th>Auditorija</th>
            <th>Komentaras</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        {% for lecture in lectures %}
            <tr>
                <td>{{ lecture.LectureId }}</td>
                <td>{{ lecture.Date }}&nbsp;<span class="label label-default">{{ lecture.Date|date('l')|replace({'Monday':'Pr','Tuesday':'An','Wednesday':'Tr','Thursday':'Kt','Friday':'Pn','Saturday':'Št','Sunday':'Sk'}) }}</span></td>
                <td>{{ lecture.TimeStart }}</td>
                <td>{{ lecture.TimeEnd }}</td>
                <td>{{ lecture.Classroom }}</td>
                <td>{{ lecture.Notes }}</td>
                <td><a href="#" class="btn btn-xs btn-primary modalwin" data-modal-title="Paskaitos"  data-modal-width="800px" data-modal-url="{{ urlFor('ajax/lecture/edit', {'id':lecture.LectureId}) }}">Redaguoti</a></td>
            </tr>
        {% endfor %}
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Diena</th>
            <th>Pradžia</th>
            <th>Pabaiga</th>
            <th>Auditorija</th>
            <th>Komentaras</th>
            <th>Veiksmai</th>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function() {
        $('#lecture_list').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "paging": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "order": false
        });
    });
</script>
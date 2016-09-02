<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'PROFESSORS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Dėstytojai</span>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped table-condensed table-hover">
                            <thead>
                            <tr>
                                <th>.</th>
                                <th>Pavardė</th>
                                <th>Vardas</th>
                                <th>El.paštas</th>
                                <th>Laipsnis</th>
                            </tr>
                            </thead>
                            <tbody>
                                {% for professor in professors %}
                                    <tr {% if professor.IsActive == 0 %}style="text-decoration: line-through" {% endif %}>
                                        <td>{{ professor.row }}</td>
                                        <td><a href="{{ urlFor('admin/professor', {'id':professor.ProfessorId}) }}">{{ professor.LastName }}</a></td>
                                        <td><a href="{{ urlFor('admin/professor', {'id':professor.ProfessorId}) }}">{{ professor.FirstName }}</a></td>
                                        <td>{{ professor.Email }}</td>
                                        <td>{{ professor.Degree }}</td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>.</th>
                                <th>Pavardė</th>
                                <th>Vardas</th>
                                <th>El.paštas</th>
                                <th>Laipsnis</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


{% include 'Kaukaras.Admin/footer.php' %}
<script>
    $(function () {
        $('#example1').DataTable({
            "scrollY": "50vh",
            "scrollX": true,
            "scrollCollapse": true,
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[0, "asc"]], /*Order by `row` column*/
            "columnDefs": [
                {
                    "targets": [0],
                    //"visible": false, /*Hides `row` column*/
                    "searchable": false
                }
            ]
        });
    });
</script>
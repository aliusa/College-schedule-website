<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Auditorijos</span>
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
                                <th>Pavadinimas</th>
                                <th>Vietų sk.</th>
                                <th>Skyrius</th>
                            </tr>
                            </thead>
                            <tbody>
                                {% for classroom in classrooms %}
                                    <tr class="clickable-row modalwin"
                                        data-modal-url="{{ urlFor('ajax/classroom/edit', {'id':classroom.ClassroomId}) }}"
                                        data-modal-title="Auditorijos redagavimas">
                                        <td>{{ classroom.Name }}</a></td>
                                        <td>{{ classroom.Vacancy }}</a></td>
                                        <td>{{ classroom.Faculty }}</a></td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Pavadinimas</th>
                                <th>Vietų sk.</th>
                                <th>Skyrius</th>
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
            "order": [[2, "asc"]]
        });
    });
</script>
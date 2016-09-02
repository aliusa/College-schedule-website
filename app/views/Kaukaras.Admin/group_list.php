{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'GROUPS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Grupės</span>
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
                                <th>Skyrius</th>
                                <th>Studijų forma</th>
                                <th>Studijų programa</th>
                                <th>Įstojimo metai</th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for group in groups %}
                            <tr {% if group.IsActive== 0 %} style="text-decoration: line-through" {%
                                endif %}>
                                <td><a href="{{ urlFor('admin/group', {'id':group.ClusterId}) }}">{{ group.Name }}</a>
                                </td>
                                <td>{{ group.Faculty }}</td>
                                <td>{{ group.StudyForm }}</td>
                                <td>{{ group.Field }}</td>
                                <td>{{ group.StartYear }}</td>
                            </tr>
                            {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Pavadinimas</th>
                                <th>Skyrius</th>
                                <th>Studijų forma</th>
                                <th>Studijų programa</th>
                                <th>Įstojimo metai</th>
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
            "order": [[0, "asc"]]
        });
    });
</script>
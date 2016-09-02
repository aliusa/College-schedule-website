<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'SCHEDULES'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Moduliai</span>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>Semestras</th>
                                <th>Dalykas</th>
                                <th>Grupės</th>
                                <th>Kreditai</th>
                                <th>sortOrder</th>
                            </tr>
                            </thead>
                            <tbody>
                                {% for schedule in schedules %}
                                <tr class="clickable-row"
                                    data-href="{{ urlFor('admin/module', {'id':schedule.ModuleId}) }}">
                                    <td>{{ schedule.semester_name }}</td>
                                    <td><a href="{{ urlFor('admin/subject', {'id':schedule.SubjectId}) }}">{{ schedule.subject_name }}</a></td>
                                    <td>
                                        {% for group in schedule.groups %}{% if previous != empty %}<br/>{% endif %}
                                            <a href="{{ urlFor('admin/group', {'id':group.ClusterId}) }}">{{ group.Name }}</a>{% set previous = group %}
                                            {% if group.IsChosen == 1 %}<span class="label label-success">Pasirenkamasis</span>{% endif %}
                                        {% endfor %}
                                    </td>
                                    <td>{{ schedule.Credits }}</td>
                                    <td>{{ schedule.SortOrder }}</td>
                                </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Semestras</th>
                                <th>Dalykas</th>
                                <th>Grupės</th>
                                <th>Kreditai</th>
                                <th>sortOrder</th>
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
    $(document).ready(function ($) {
        $(function () {
            $('#example1').DataTable({
                "scrollY": "80vh",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "order": [[4, "asc"]], /*order by Semester.SortOrder, because Datatable doesn't sort by UTF8*/
                "columnDefs": [
                    {
                        "targets": [ 4 ],
                        "visible": false, /*Hides SortOrder column*/
                        "searchable": false
                    }
                ]
            });
        });

        $(".clickable-row").click(function () {
            window.document.location = $(this).data("href");
        });
    });
</script>
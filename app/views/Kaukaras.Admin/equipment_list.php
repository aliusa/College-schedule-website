<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Įranga</span>
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
                                    <th>Techninė</th>
                                    <th>Programinė</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for item in hardware %}
                                    <tr>
                                        <td>{{ item.Name }}</td>
                                        <td>{% if item.Type == 1 %}✓{% endif %}</td>
                                        <td>{% if item.Type == 2 %}✓{% endif %}</td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Pavadinimas</th>
                                    <th>Techninė</th>
                                    <th>Programinė</th>
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
            "info": false,
            "autoWidth": true,
            "order": [[0, "asc"]]
        });
    });
</script>
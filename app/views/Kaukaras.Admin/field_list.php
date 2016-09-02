<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Studijų programos</span>
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
                                    <th>ID</th>
                                    <th>Pavadinimas</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for field in fields %}
                                    <tr class="clickable-row modalwin"
                                        data-modal-url="{{ urlFor('ajax/field/edit', {'id':field.OptionsDetailsId}) }}"
                                        data-modal-title="Studijų programos redagavimas">
                                        <td>{{ field.OptionsDetailsId }}</td>
                                        <td>{{ field.Name }}</a></td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Pavadinimas</th>
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
            "order": [[1, "asc"]]
        });
    });
</script>
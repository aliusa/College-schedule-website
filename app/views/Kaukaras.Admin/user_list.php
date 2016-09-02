<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Personalas</span>
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
                                <th>Vardas</th>
                                <th>Pavardė</th>
                                <th>El. paštas</th>
                            </tr>
                            </thead>
                            <tbody>
                                {% for user_item in users %}
                                    <tr {% if user_item.IsActive == 0 %} style="text-decoration: line-through"{% endif %}>
                                        <td><a href="{{ urlFor('admin/user', {'id':user_item.UserId}) }}">{{user_item.FirstName}}</a></td>
                                        <td><a href="{{ urlFor('admin/user', {'id':user_item.UserId}) }}">{{user_item.LastName}}</a></td>
                                        <td>{{user_item.Email}}</td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Vardas</th>
                                <th>Pavardė</th>
                                <th>El. paštas</th>
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
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": true
        });
    });
</script>
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#maininfo">Pagrindinė informacija</a></li>
        <li><a href="#loginlog">Prisijungimų istorija</a></li>
    </ul>

    <!-- Main content -->
    <section class="content">

        <div class="tab-content">
            <div class="tab-pane active" id="maininfo">
                <div class="row">
                    <div class="col-md-8">
                        <!-- SELECT2 EXAMPLE -->
                        <div class="box box-default">
                            <!-- form start -->
                            <form role="form" method="POST">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="firstname">Vardas</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-male"></i>
                                                </div>
                                                <input type="text" class="form-control" id="firstname" name="firstname"
                                                       autocomplete="on" placeholder="" required pattern=".{1,255}"
                                                       title="Nuo 1 iki 255 ilgis" value="{{ admin.FirstName }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="lastname">Pavardė</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-male"></i>
                                                </div>
                                                <input type="text" class="form-control" id="lastname" name="lastname"
                                                       autocomplete="on" placeholder="" required pattern=".{5,255}"
                                                       title="Nuo 5 iki 255 ilgis" value="{{ admin.LastName }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">El.paštas</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input type="text" class="form-control" id="email" name="email"
                                                       autocomplete="on" placeholder="" required pattern=".{5,255}"
                                                       title="Nuo 5 iki 255 ilgis" value="{{ admin.Email }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-sm btn-success">Išsaugoti</button>
                                </div>
                            </form>
                        </div><!-- /.box -->
                    </div> <!--/.col-xs-12-->
                </div> <!--/.row-->
            </div>
            <div class="tab-pane" id="loginlog">
                <!-- RecurringTask schedule -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-body">
                                <table id="example1"
                                       class="table table-bordered table-striped table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Diena</th>
                                        <th>OS</th>
                                        <th>Naršyklė</th>
                                        <th>Rezoliucija</th>
                                        <th>IP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {% for login in logins %}
                                    <tr class="expandable-datatable">
                                        <td>{{ login.DateTime }}</td>
                                        <td>{{ login.Browser }}</td>
                                        <td>{{ login.Platform }}</td>
                                        <td>{{ login.Resolution }}</td>
                                        <td>{{ login.IP }}</td>
                                    </tr>
                                    {% endfor %}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Diena</th>
                                        <th>OS</th>
                                        <th>Naršyklė</th>
                                        <th>Rezoliucija</th>
                                        <th>IP</th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

{% include 'Kaukaras.Admin/footer.php' %}

<script type="text/javascript">
    colorRequiredFormValidation();

    $('#example1').DataTable({
        "paging": true,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "order": [[0, 'desc']]
    });

    // Tabs
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>
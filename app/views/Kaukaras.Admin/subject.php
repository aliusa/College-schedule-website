{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'SUBJECTS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-group"></i><span>Dalyko <b>{{ subject.Name}}</b> informacija</span
        </h1>
    </section>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#maininfo">Pagrindinė informacija</a></li>
    </ul>

    <!-- Main content -->
    <section class="content">
        <div class="tab-content">
            <div class="tab-pane active" id="maininfo">
                <!-- SELECT2 EXAMPLE -->
                <div class="box box-default">
                    <!-- form start -->
                    <form role="form" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Pavadinimas</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           autocomplete="on" placeholder="" required pattern=".{3,255}"
                                           title="Nuo 3 iki 255 ilgis" value="{{ subject.Name }}"/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IsntActive">Dalykas nebeskaitomas</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="IsntActive" {% if subject.IsActive== 0 %}
                                                       checked{% endif %} id="IsntActive">Taip
                                            </label>
                                        </div><!--/.checkbox-->
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-sm btn-success">Išsaugoti</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

{% include 'Kaukaras.Admin/footer.php' %}

<script type="text/javascript">
    colorRequiredFormValidation();
    // Tabs
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>
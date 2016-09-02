<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'INDEX'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Informacijos skydelis
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ lectures.Count }}</h3>
                        <p>Paskaitos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-flag"></i>
                    </div>
                </div>
            </div><!--/.col-->
			{% if ("now"|date("H") in range(7,10)) and (loggedToday is empty) %}
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>Labas rytas,</h3>
							<p>{{ user|split(' ')[0] }}</p>
						</div>
						<div class="icon">
							<i class="ion ion-android-sunny"></i>
						</div>
					</div>
				</div><!--/.col-->
			{% endif %}
        </div><!--/.row-->

        <div class="row">

            <!-- Left col -->
            <div class="col-md-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Paskutiniai prisijungimai</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Administratorius</th>
                                    <th>Statusas</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for login in logins %}
                                <tr>
                                    <td>{{ login.DateTime }}</td>
                                    <td>{% if login.FullName is empty %}{{ login.ip }}
                                        {% else %}<a href="{{ urlFor('admin/user', {'id': login.UserId }) }}">
                                            {{ login.FullName }}</a>{% endif %}</td>
                                    <td>{% if login.Success == 1%}<span class="label label-success">Pavyko</span>{% else
                                        %}<span class="label label-danger">Nepavyko</span>{% endif %}
                                    </td>
                                </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->

            <!-- Left col -->
            <div class="col-md-6">
                <!-- Line chart -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Paskaitos pagal dienas</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="cal-heatmap"></div>
                    </div><!-- /.box-body-->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!--/.row-->
    </section>

</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $.ajax({
        type: "POST",
        url: "{{ urlFor('ajax/lecture/count') }}",
        success: function (result) {
            var datas = JSON.parse(result);

            var parser = function(data) {
                var stats = {};
                for (var d in data) {
                    stats[data[d].date] = data[d].value;
                }
                return stats;
            };

            var dt = new Date();

            // Start displaing calendar from one month back.
            var startMonth = dt.getMonth() -1;
            var startYear = datas[0].Year;
            if (startMonth == -1) {
                startYear--;
                startMonth = 11;
            }

            var cal = new CalHeatMap();
            cal.init({
                domain: "month",
                subDomain: "day",
                data: datas,
                afterLoadData: parser,
                start: new Date(startYear, startMonth),
                range: 4, // Display # months
                cellSize: 20,
                subDomainTextFormat: "%d", // Display day in cell
                highlight: ["now", dt], // Hightlight today
                legend: [1, 4, 6, 6, 8, 10],
                tooltip: true,
            });
        }
    });

</script>
{% include 'Kaukaras.Admin/footer.php' %}

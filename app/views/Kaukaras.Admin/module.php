<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'SCHEDULES'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-group"></i><span>{{ semester }}. {{ subject }}</span
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-6">

                <div class="box box-default">

                    <div class="box-header with-border">
                        <h3 class="box-title">Priskirtos grupės/pogrupiai</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table id="example2"
                               class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Grupė/pogrupis</th>
                                    <th>Pasirenkamasis</th>
                                    <th>Veiksmas</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for subcluster in subclusters %}
                                    <tr>
                                        <td>{{ subcluster.Name }}</td>
                                        <td>{% if subcluster.IsChosen == 1 %}<span class="label label-success">Pasirenkamasis</span>{% else %}Ne{% endif %}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs"
                                                    data-comfirm="Ar tikrai norite ištrinti šį pogrupį?"
                                                    onclick='deleteRecord("{{ baseUrl() }}","module_cluster","ModuleClusterId", "{{ subcluster.ModuleClusterId }}")'>
                                                Ištrinti
                                            </button>
                                        </td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Grupė/pogrupis</th>
                                    <th>Pasirenkamasis</th>
                                    <th>Veiksmas</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <a href="#" class="btn btn-warning btn-xs modalwin"
                           data-modal-url="{{ urlFor('ajax/module/edit', {'id':module.ModuleId}) }}" data-modal-action="edit"
                           data-modal-title="Redaguoti įrašą"
                           data-modal-width="700px">
                            <i class="glyphicon glyphicon-pencil"></i>
                            <span class="hidden-480">Redaguoti</span>
                        </a>

                        <a href="#" class="btn btn-success btn-xs modalwin"
                           data-modal-url="{{ urlFor('ajax/module_subcluster/add', {'id':module.ModuleId}) }}" data-modal-action="edit"
                           data-modal-title="Pridėti pogrupį"
                           data-modal-width="700px">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span class="hidden-480">Pridėti pogrupį</span>
                        </a>
                    </div>

                </div><!-- /.box -->
            </div>
        </div>

        <!-- RecurringTask schedule -->
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-default">

                    <div class="box-header with-border">
                        <h3 class="box-title">Tvarkaraščio kortelės</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1"
                               class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Grupė</th>
                                    <th>Data nuo</th>
                                    <th>Data iki</th>
                                    <th>Dėstytojas</th>
                                    <th>Paskaitos</th>
                                    <th>Veiksmai</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for schedule in schedules %}
                                    <tr>
                                        <td>{{ schedule.RecurringTaskId }}</td>
                                        <td><a href="{{ urlFor('admin/group', {'id':schedule.ClusterId}) }}">{{
                                                schedule.Name }} </a><span
                                                class="badge{% if schedule.lecture_count == 0 %} progress-bar-danger{% endif %}">{{ schedule.lecture_count }}</span>
                                            {% if schedule.IsChosen != NULL %}<span class="label label-info">Pasirenkamasis</span>{%
                                            endif %}
                                        </td>
                                        <td>{{ schedule.DateStart }}
                                            <span class="label label-default">{{ schedule.DateStart|date('l')|replace({'Monday':'Pr','Tuesday':'An','Wednesday':'Tr','Thursday':'Kt','Friday':'Pn','Saturday':'Št','Sunday':'Sk'}) }}</span>
                                        </td>
                                        <td>{{ schedule.DateEnd }}
                                            <span class="label label-default">{{ schedule.DateEnd|date('l')|replace({'Monday':'Pr','Tuesday':'An','Wednesday':'Tr','Thursday':'Kt','Friday':'Pn','Saturday':'Št','Sunday':'Sk'}) }}</span>
                                        </td>
                                        <td>{{ schedule.Professor }}</td>
                                        <td>{{ schedule.msg }}</td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary modalwin"
                                               data-modal-title="Paskaitos"  data-modal-width="800px"
                                               data-modal-url="{{ urlFor('ajax/lecture/view', {'id':schedule.RecurringTaskId}) }}">Peržiūrėti paskaitas</a>

                                            <a href="#" class="btn btn-warning btn-xs modalwin"
                                               data-modal-url="{{ urlFor('ajax/recurringtask/edit', {'id':schedule.RecurringTaskId}) }}" data-modal-action="edit"
                                               data-modal-title="Redaguoti įrašą"
                                               data-modal-width="700px">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                                <span class="hidden-480">Redaguoti</span>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-xs"
                                                    data-comfirm="Ar tikrai norite ištrinti šias paskaitas?"
                                                    onclick='deleteRecord("{{ baseUrl() }}","recurringtask","RecurringTaskId", "{{ schedule.RecurringTaskId }}")'>
                                                Ištrinti
                                            </button>
                                        </td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Grupės</th>
                                    <th>Data nuo</th>
                                    <th>Data iki</th>
                                    <th>Dėstytojas</th>
                                    <th>Paskaitos</th>
                                    <th>Veiksmai</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <!--Show delete form if no schedules present.-->
                        {% if schedules is empty %}
                            <button type="button" class="btn btn-danger btn-xs"
                                data-comfirm="Ar tikrai norite ištrinti šias paskaitas?"
                                onclick='deleteRecord("{{ baseUrl() }}","module","ModuleId", "{{ id }}")'>
                                Ištrinti modulį</button>
                        {% endif %}
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

{% include 'Kaukaras.Admin/footer.php' %}

<script type="text/javascript">
    $(document).ready(function () {
        colorRequiredFormValidation();

        $('#example1').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[2, 'desc']]
        });
    });
</script>
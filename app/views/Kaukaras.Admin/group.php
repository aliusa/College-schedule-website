<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'GROUPS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-group"></i><span>Grupės <b>{{ group.Name }}</b> informacija</span>
        </h1>
    </section>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#maininfo">Pagrindinė informacija</a></li>
        <li><a href="#schedule">Tvarkaraščiai</a></li>
        <li><a href="#subclusterList">Pogrupiai</a></li>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Pavadinimas</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="" required pattern=".{3,20}" title="Nuo 3 iki 20 ilgis"
                                               value="{{ group.Name }}"/>
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">El.paštas</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" id="email" name="email"
                                               placeholder="" pattern=".{5,30}" title="Nuo 5 iki 20 ilgis"
                                               value="{{ group.Email }}"/>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fieldId">Studijų pavadinimas</label>
                                        <select class="form-control select2" name="fieldId" style="width: 100%;"
                                                id="fieldId">
                                            {% for field in fields %}
                                                {% if group.FieldId == field.OptionsDetailsId %}
                                                    <option value="{{ field.OptionsDetailsId }}" selected>{{ field.Name }}
                                                    </option>
                                                {% else %}
                                                    <option value="{{ field.OptionsDetailsId }}">{{ field.Name }}</option>
                                                {% endif %}
                                            {% endfor %}
                                        </select>
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formId">Studijų forma</label>
                                        <select class="form-control select2" name="formId" id="formId">
                                            {% for form in forms %}
                                            {% if group.StudyFormId == form.OptionsDetailsId %}
                                            <option value="{{ form.OptionsDetailsId }}" selected>{{ form.Name }}
                                            </option>
                                            {% else %}
                                            <option value="{{ form.OptionsDetailsId }}">{{ form.Name }}</option>
                                            {% endif %}
                                            {% endfor %}
                                        </select>
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facultyId">Skyrius</label>
                                        <select class="form-control select2" name="facultyId" id="facultyId">
                                            {% for faculty in faculties %}
                                            {% if group.FacultyId == faculty.FacultyId %}
                                            <option value="{{ faculty.FacultyId }}" selected>{{ faculty.Name
                                                }}
                                            </option>
                                            {% else %}
                                            <option value="{{ faculty.FacultyId }}">{{ faculty.Name }}
                                            </option>
                                            {% endif %}
                                            {% endfor %}
                                        </select>
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pogrupiai">Grupė baigė kolegiją</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="IsActive" {% if group.IsActive== 0 %}
                                                       checked{% endif %}>Taip
                                            </label>
                                        </div><!--/.checkbox-->
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                            </div> <!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startYear">Įstojimo metai</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">#</span>
                                            <input type="number" class="form-control"
                                                   placeholder="0000" id="startYear" name="startYear"
                                                   min="2000" max="2050"
                                                   value="{{ group.StartYear }}"
                                                   aria-describedby="basic-addon1">
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-sm btn-success">Išsaugoti</button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-comfirm="Ar tikrai norite ištrinti šią grupę su visais jos pogrupiais?"
                                    onclick='deleteRecord("{{ baseUrl() }}","cluster","ClusterId", "{{ group.ClusterId }}")'>
                                Ištrinti
                            </button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
            <div class="tab-pane" id="schedule">
                <!-- RecurringTask schedule -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="example1"
                                       class="table table-bordered table-striped table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grupė</th>
                                        <th>Dalykas</th>
                                        <th>Semestras</th>
                                        <th>Kreditai</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {% for schedule in schedules %}
                                    <tr
                                        data-schedule-url="{{ urlFor('ajax/schedule/read', {'id':schedule.ModuleId, 'group':group.ClusterId}) }}"
                                        data-lecture-url="{{ urlFor('ajax/lecture/view', {'id':''}) }}"
                                        class="expandable-datatable">
                                        <td>{{ schedule.ModuleId }}</td>
                                        <td>{{ schedule.group }} <span
                                                class="badge{% if schedule.lecture_count == 0 %} progress-bar-danger{% endif %}">{{ schedule.lecture_count }}</span>
                                        </td>
                                        <td>{{ schedule.Subject }}&nbsp;{% if schedule.IsChosen == 1 %}<span
                                                class="label label-info">Pasirenkamasis</span>{%endif %}
                                        </td>
                                        <td>{{ schedule.Semester }}</td>
                                        <td>{{ schedule.Credits }}</td>
                                    </tr>
                                    {% endfor %}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grupė</th>
                                        <th>Dalykas</th>
                                        <th>Semestras</th>
                                        <th>Kreditai</th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <div class="tab-pane" id="subclusterList">
                <!-- RecurringTask schedule -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="example1"
                                       class="table table-bordered table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Pavadinimas</th>
                                            <th>Veiksmai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for subcluster in subclusters %}
                                            <tr>
                                                <td>
                                                    {% if subcluster.Name == '0' %}
                                                        (Visa grupė)
                                                    {% else %}
                                                        {{ subcluster.Name }}
                                                    {% endif %}
                                                </td>
                                                <td>
                                                    {% if subcluster.Name != '0' %}
                                                    <a href="#" class="btn btn-warning btn-xs modalwin"
                                           data-modal-url="{{ urlFor('ajax/subcluster/edit', {'id':subcluster.ClusterId}) }}"
                                           data-modal-action="edit"
                                           data-modal-title="Redaguoti pogrupį"
                                           data-modal-width="700px"><i class="glyphicon glyphicon-pencil"></i> <span class="hidden-480">Redaguoti</span></a>
                                                    {% endif %}
                                                </td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Pavadinimas</th>
                                            <th>Veiksmai</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a href="#" class="btn btn-primary pull-right modalwin"
                                   data-modal-url="{{ urlFor('ajax/subcluster/add', {'id':group.ClusterId}) }}"
                                   data-modal-title="Pridėti pogrupį"
                                   data-modal-width="600px">Pridėti pogrupį</a>
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
        "paging": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "order": [[3, 'desc']]
    });

    // Tabs
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>
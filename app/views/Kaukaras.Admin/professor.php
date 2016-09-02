<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'PROFESSORS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-group"></i><span>Asmens <b>{{ professor.FirstName}}
                    {{professor.LastName}}</b> informacija</span
        </h1>
    </section>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li><a href="#maininfo">Pagrindinė informacija</a></li>
        <li class="active"><a href="#schedule">Tvarkaraščiai</a></li>
    </ul>

    <!-- Main content -->
    <section class="content">
        <div class="tab-content">
            <div class="tab-pane" id="maininfo">
                <!-- SELECT2 EXAMPLE -->
                <div class="box box-default">
                    <!-- form start -->
                    <form role="form" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Vardas</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                            </div>
                                            <input type="text" class="form-control" id="name" name="FirstName"
                                               placeholder="" required pattern=".{2,255}" title="Nuo 2 iki 60 ilgis"
                                               value="{{ professor.FirstName }}"/>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="surname">Pavardė</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                            </div>
                                            <input type="text" class="form-control" id="surname" name="LastName"
                                               placeholder="" required pattern=".{2,255}" title="Nuo 2 iki 60 ilgis"
                                               value="{{ professor.LastName }}"/>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">El.paštas</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" id="email" name="email"
                                                   placeholder="" value="{{ professor.Email }}"/>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="degree">Mokslinis laipsnis</label>
                                        <select class="form-control select2" name="degree" id="degree">
                                            {% if professor.DegreeId is empty %}
                                            <option value="{{ degree.OptionsDetailsId }}" selected>-- nepasirinkta --
                                            </option>
                                            {% endif %}

                                            {% for degree in degries %}
                                            {% if professor.DegreeId == degree.OptionsDetailsId %}
                                            <option value="{{ degree.OptionsDetailsId }}" selected>{{ degree.Name}}
                                            </option>
                                            {% else %}
                                            <option value="{{ degree.OptionsDetailsId }}">{{ degree.Name }}</option>
                                            {% endif %}
                                            {% endfor %}
                                            <option value="0">-- nepasirinkta --</option>
                                        </select>
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="notes">Papildoma informacija</label>
                                        <textarea class="form-control" rows="5" name="notes"
                                                  id="notes">{{ professor.Notes }}</textarea>
                                    </div><!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IsntActive">Dėstytojas nebedirba</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="IsntActive" {% if professor.IsActive== 0 %}
                                                       checked{% endif %} id="IsntActive">Taip
                                            </label>
                                        </div><!--/.checkbox-->
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="semesters">Dirba semestrus</label><br/>
                                        <select class="form-control select2" name="semesters[]" id="semesters" multiple>
                                            {% if semesters is empty %}
                                                <option disabled>Nėra sukurtų semestrų</option>
                                            {% else %}
                                                {% for semester in semesters %}
                                                    <option value="{{ semester.SemesterId }}"
                                                            {% if semester.ProfessorId is not empty %}selected{% endif %}>{{ semester.Name }}</option>
                                                {% endfor %}
                                            {% endif %}
                                        </select>
                                    </div><!-- /.form-group -->
                                </div><!--/.col-md-6-->
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-sm btn-success">Išsaugoti</button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-comfirm="Ar tikrai norite ištrinti šį dėstytoją?"
                                    onclick='deleteRecord("{{ baseUrl() }}","professor","ProfessorId", "{{ professor.ProfessorId }}")'>
                                Ištrinti
                            </button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
            <div class="tab-pane active" id="schedule">
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
                                    <tr data-schedule-url="{{ urlFor('ajax/recurringtask/read', {'id':schedule.ModuleId}) }}"
                                        data-lecture-url="{{ urlFor('ajax/lecture/view', {'id':''}) }}"
                                        class="expandable-datatable">
                                        <td>{{ schedule.ModuleId }}</td>
                                        <td>{{ schedule.group }} <span
                                                class="badge{% if schedule.lecture_count == 0 %} progress-bar-danger{% endif %}">{{ schedule.lecture_count }}</span>
                                        </td>
                                        <td>{{ schedule.Subject }}&nbsp;{% if schedule.IsChosen == 1 %}<span class="label label-info">Pasirenkamasis</span>{%endif %}</td>
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
            </div
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

    $('#semesters').multiselect({
            maxHeight: 300,
            enableFiltering: true,
            filterPlaceholder: 'Ieškoti...',
            nonSelectedText: 'Pasirinkite',
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '250px'
        });
</script>
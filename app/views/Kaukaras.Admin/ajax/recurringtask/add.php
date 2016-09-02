<!--@formatter:off-->
<form role="form" method="POST" id="schedule-layout">
    <input type="hidden" name="action" value="add"/>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#mainInfoAdding">Pagrindinė informacija</a></li>
        <li><a href="#datetime">Data ir laikas</a></li>
    </ul>

    <div class="modal-body">
        <div class="tab-content">
            <div class="tab-pane active" id="mainInfoAdding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="module">Modulis</label>
                            <select class="form-control select2" name="module" id="module">
                                <option disabled selected> -- pasirinkite  -- </option>
                                {% for module in modules %}
                                    <option value="{{ module.ModuleId }}">{{ module.Semester }} ; {{ module.Subject }} ({{ module.Credits }} kreditai)</option>
                                {% endfor %}
                            </select>
                        </div><!-- /.form-group -->
                    </div><!--.col-md-12-->
                </div><!--/.row-->

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="group">Grupė (pogrupis)</label>
                            <select class="form-control select2" name="group[]" id="group" multiple size="10">
                            </select>
                        </div><!-- /.form-group -->
                    </div>
    
                    <div class="col-md-6">
    
                        <div class="form-group">
                            <label for="professor">Dėstytojas (dirbantys tą semestrą)</label>
                            <select class="form-control select2" name="professor" id="professor">
                                <option disabled selected> -- Pasirinkite modulį  -- </option>
                            </select>
                        </div><!-- /.form-group -->
                    </div><!-- /.col -->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="classroom">Auditorija</label>
                            <select class="form-control select2" name="classroom" id="classroom">
                                <option disabled selected> -- pasirinkite  -- </option>
                                {% for classroom in classrooms %}
                                    {% if classroom.faculty_id != previous_faculty %}
                                        <option disabled class="option_item_disabled">{{ classroom.faculty_name }}</option>
                                    {% endif %}
                                        <option value="{{ classroom.id }}">{{ classroom.Name }}</option>
                                    {% set previous_faculty = classroom.faculty_id %}
                                {% endfor %}
                            </select>
                        </div><!-- /.form-group -->
                    </div>

                </div>
            </div>

            <div class="tab-pane" id="datetime">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-inline">
                            <label for="occurs">Įvyksta kas</label>
                            <select class="form-control" name="occurs" id="occurs">
                                <option value="1">Vieną kartą</option>
                                <option value="3" selected>Savaitę</option>
                                <option value="5">Pasirinktomis dienomis</option>
                            </select>
                        </div><!-- /.form-group -->
                    </div>
                </div>

                <fieldset id="fieldset_ocurrences">
                    <legend>Kartojimas</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-inline">
                                <label for="occurs_every">Įvyksta kas (n) savaitę</label>
                                <input class="form-control input-small" type="number" min="1" max="10" name="occurs_every" required
                                   value="1" id="occurs_every"/>
                            </div><!-- /.form-group -->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weekdays" class="control-label">Šiomis dienomis</label>
                                <div class="form-group" style="margin-top:10px;">
                                    <input type="checkbox" id="weekday1" name="weekdays[]" value="1" style="opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday1"> Pr<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday2" name="weekdays[]" value="2" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday2"> An<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday3" name="weekdays[]" value="3" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday3"> Tr<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday4" name="weekdays[]" value="4" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday4"> Kt<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday5" name="weekdays[]" value="5" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday5"> Pn<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday6" name="weekdays[]" value="6" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday6"> Št<span class="mask"></span></label>
                                    <input type="checkbox" id="weekday7" name="weekdays[]" value="7" style="margin-left:10px;opacity:0;position:absolute; left:299px;" ><label class="demoCheck" for="weekday7"> Sk<span class="mask"></span></label>
                                </div>
                            </div><!-- /.form-group -->
                        </div>
                    </div>
                </fieldset>

                <fieldset id="fieldset_datetimeinterval" >
                <legend>Laikas</legend>
                    <div id="time_interval">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="time_start">Pradžios laikas (hh:mm)</label>
                                <input type="time" class="form-control" name="time_start" id="time_start" required placeholder="23:59"/>
                            </div>

                            <div class="form-group">
                                <label for="time_end">Pabaigos laikas (hh:mm)</label>
                                <div class="form-group">
                                    <div class="radio radio-inline">
                                        <label>
                                            <div style="display:inline-block; position:relative;" id="time_default">
                                                <input type="hidden" name="time_end_default" value="01:30">
                                                <input type="radio" name="time_end[]" checked value="0" id="time_end_0">
                                                <span><input type="time" name="time_end_id[]" id="time_end_default" value="01:30" step="300" disabled />
                                                    <span>Įprasta trukmė</span></span>
                                                <div style="position:absolute; left:0; right:0; top:0; bottom:0;"></div><!--for radio checking-->
                                            </div>
                                        </label>
                                    </div>
                                    <br/>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="time_end[]" value="1" id="time_end_1">
                                            <span><input type="time" name="time_end_id[]" id="time_end_other_length" step="300" placeholder="03:00"/>
                                                <span style="display:inline">Kita trukmė </span></span>
                                        </label>
                                    </div>
                                    <br/>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="time_end[]" value="2" id="time_end_2">
                                            <span><input type="time" name="time_end_id[]" id="time_end_specific_time" step="300" placeholder="23:59"/>
                                                <span>Baigiasi pasirinktu laiku: </span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                <div id="date_picker_multi" style="display: none">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="occurs_specific_dates"
                                   name="occurs_specific_dates" placeholder="2015-12-31">
                            <div id="date_picker_multi_picker" style="width: 100%;border: 1px solid black;"></div>
                        </div>
                    </div>

                <div id="date_picker_once" style="display: none">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="occurs_once" name="occurs_once"
                               placeholder="2015-12-31">
                        <div id="date_picker_once_picker" style="width: 100%;border: 1px solid black;"></div>
                    </div>
                </div>


                <div id="date_interval">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="date_start">Pradžios data</label>
                                <div class="input-group input-append date datepick">
                                    <input type="text" class="form-control" name="date_start"
                                           data-fv-notempty="true"
                                           data-fv-notempty-message="Data yra privaloma"
                                           data-fv-date="true"
                                           data-fv-date-format="YYYY-MM-DD"
                                           data-fv-date-message="Neteisingo formato data"
                                           placeholder="2015-12-31"
                                    />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_end">Pabaigos data</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="date_end[]" checked value="0" id="date_end_0">
                                        <div class="input-group input-append date datepick">
                                            <input type="text" class="form-control" name="date_end_id_0" id="date_end_specific_date"
                                                   placeholder="2015-12-31"/>
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="date_end[]" value="1" id="date_end_1">
                                            Po <input class="form-control input-small" type="number"
                                                      id="date_end_after_ocurrences_lecture"
                                                      name="date_end_id_1" placeholder="0"/> paskaitų
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="date_end[]" value="2" id="date_end_2">
                                            Po <input class="form-control input-small" type="number"
                                                      id="date_end_after_ocurrences_week"
                                                      name="date_end_id_2" placeholder="0"/> savaičių
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </fieldset>
            </div>
        </div>
    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" id="save_schedule" onclick="submitForm('#schedule-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>

</form>

<script type="text/javascript">
    colorRequiredFormValidation();
    noCtrlKeyForSelect();

    // Tabs
    $('#myTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // DatePicker
    $(document).ready(function() {
        $('.datepick')
            .datepicker({
                startDate: '2010-01-01',
                endDate: '2030-12-31',
                language: "lt",
                calendarWeeks: true,
                todayHighlight: true
            })
            .on('changeDate', function(e) {
                // Revalidate the date field
                $('#dateRangeForm').formValidation('revalidateField', 'date_start');
            });

        // Multiple dates input
        $('#date_picker_multi_picker').datepicker({
            clearBtn: true,
            weekStart: 1,
            language: "lt",
            multidate: true,
            multidateSeparator: ", ",
            // daysOfWeekDisabled: "0",
            calendarWeeks: true,
            // toggleActive: true,
            daysOfWeekHighlighted: "0,6",
            todayHighlight: true
        });
        $('#date_picker_multi_picker').on("changeDate", function () {
            $('#occurs_specific_dates').val(
                $('#date_picker_multi_picker').datepicker('getFormattedDate')
            );
        });
        // Once dates input
        $('#date_picker_once_picker').datepicker({
            clearBtn: true,
            weekStart: 1,
            language: "lt",
            multidate: false,
            // daysOfWeekDisabled: "0",
            calendarWeeks: true,
            // toggleActive: true,
            daysOfWeekHighlighted: "0,6",
            todayHighlight: true
        });
        $('#date_picker_once_picker').on("changeDate", function () {
            $('#occurs_once').val(
                $('#date_picker_once_picker').datepicker('getFormattedDate')
            );
        });

        //$('#schedule-layout').formValidation();

        // Checkboxes of weekdays
        $('label.demoCheck').on('click', function(){
            $(this).toggleClass('demoCheckactive');
        });
    });

    /*Hides/shows elements devending on occurence.*/
    $('select[id="occurs"]').change(function() {
        if (this.value == 0) {
            /**/
        } else if (this.value == 1) {
            // One time
            document.getElementById("fieldset_ocurrences").style.display = "none";

            document.getElementById("date_interval").style.display = "none";
            document.getElementById("date_picker_multi").style.display = "none";
            document.getElementById("date_picker_once").style.display = "block";
        } else if (this.value == 2) {
            // Daily
        } else if (this.value == 3) {
            // weekly
            document.getElementById("date_interval").style.display = "block";
            document.getElementById("date_picker_multi").style.display = "none";
            document.getElementById("date_picker_once").style.display = "none";
            document.getElementById("fieldset_ocurrences").style.display = "block";
            document.getElementById("time_interval_container").style.display = "block";
        } else if (this.value == 4) {
            // monthly
        } else if (this.value == 5) {
            // On selected dates
            document.getElementById("fieldset_ocurrences").style.display = "none";

            document.getElementById("time_interval").style.display = "block";
            document.getElementById("date_interval").style.display = "none";
            document.getElementById("date_picker_once").style.display = "none";
            document.getElementById("date_picker_multi").style.display = "block";
        } else if (this.value == 6) {
            // yearly
        }
    });

    // On date end input click changes radio button to that.
    $('input[id="date_end_specific_date"]').focus(function() {
        document.getElementById("date_end_0").setAttribute("checked","true");
        document.getElementById("date_end_1").setAttribute("checked","false");
        document.getElementById("date_end_2").setAttribute("checked","false");
        document.getElementById("date_end_0").checked = true;
        document.getElementById("date_end_1").checked = false;
        document.getElementById("date_end_2").checked = false;
    });
    $('input[id="date_end_after_ocurrences_lecture"]').focus(function() {
        document.getElementById("date_end_0").setAttribute("checked","false");
        document.getElementById("date_end_1").setAttribute("checked","true");
        document.getElementById("date_end_2").setAttribute("checked","false");
        document.getElementById("date_end_0").checked = false;
        document.getElementById("date_end_1").checked = true;
        document.getElementById("date_end_2").checked = false;
    });
    $('input[id="date_end_after_ocurrences_week"]').focus(function() {
        document.getElementById("date_end_0").setAttribute("checked","false");
        document.getElementById("date_end_1").setAttribute("checked","false");
        document.getElementById("date_end_2").setAttribute("checked","true");
        document.getElementById("date_end_0").checked = false;
        document.getElementById("date_end_1").checked = false;
        document.getElementById("date_end_2").checked = true;
    });

    // Selects default time duration when input was clicked.
    $("#time_default > div").click(function (evt) {
        $(this).focus();
    });
    $('input[id="time_end_other_length"]').focus(function() {
        document.getElementById("time_end_0").setAttribute("checked","false");
        document.getElementById("time_end_1").setAttribute("checked","true");
        document.getElementById("time_end_2").setAttribute("checked","false");
        document.getElementById("time_end_0").checked = false;
        document.getElementById("time_end_1").checked = true;
        document.getElementById("time_end_2").checked = false;
    });
    $('input[id="time_end_specific_time"]').focus(function() {
        document.getElementById("time_end_0").setAttribute("checked","false");
        document.getElementById("time_end_1").setAttribute("checked","false");
        document.getElementById("time_end_2").setAttribute("checked","true");
        document.getElementById("time_end_0").checked = false;
        document.getElementById("time_end_1").checked = false;
        document.getElementById("time_end_2").checked = true;
    });

    $('select[id="module"]').change(function() {
        // Delete old select option items.
        var oldValues = document.getElementById("group");
        for(var i = oldValues.options.length-1; i >= 0; i-- ) {
            oldValues.remove(i);
        }
        
        var moduleLink = "{{ urlFor('ajax/module/read', {'id':''} ) }}";
        moduleLink += this.value;

        $.ajax({
            // Gets url from datatable to fetch from data.
            url: moduleLink,
            success: function (result) {
                var select = document.getElementById("group");

                var array = JSON.parse(result);

                for (var i = 0; i <= array.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = array[i].id;
                    opt.innerHTML = array[i].Name;
                    select.appendChild(opt);
                }
            }
        });

        // Link from there to get modules professors
        var professorLink = "{{ urlFor('ajax/professor/read', {'id':''} ) }}";
        // Module ID for which to get
        professorLink += this.value;


        // Delete old Professor select option items.
        var oldValues = document.getElementById("professor");
        for(var i = oldValues.options.length-1; i >= 0; i-- ) {
            oldValues.remove(i);
        }

        $.ajax({
            // Gets url from datatable to fetch from data.
            url: professorLink,
            success: function (result) {
                var select = document.getElementById("professor");

                var array = JSON.parse(result);

                for (var i = 0; i <= array.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = array[i].id;
                    opt.innerHTML = array[i].Name;
                    select.appendChild(opt);
                }
            }
        });
    });
</script>

<style>
    .demoCheck{
        width: 30px;
        height: 30px;
        border: 1px solid #4CAF50;
        border-radius: 5px;
        font-size: 14px;
        padding: 0px 4px;
        color: #212121;
        background-color: white;
        float: left;
        cursor: pointer;
        margin-right: 10px;
    }
    .demoCheckactive {
        border: 1px solid #4CAF50;
        color: #FFFFFF;
        background-color: #4CAF50;
    }

    /*Masking checkbox, so that label can't be selected.*/
    .demoCheck {
        position: relative;
    }
    .demoCheck .mask {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
</style>
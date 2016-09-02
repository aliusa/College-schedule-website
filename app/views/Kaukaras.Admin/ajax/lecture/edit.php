<!--@formatter:off-->
<style>
    .datepick {width:auto!important;}
</style>
<form role="form" method="POST" id="lecture-layout">
    <input type="hidden" name="action" value="edit"/>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="classroom">Auditorija</label>
                    <select class="form-control select2" name="classroom" id="classroom">
                        <option disabled selected> -- pasirinkite  -- </option>
                        {% for classroom in classrooms %}
                            {% if classroom.faculty_id != previous_faculty %}
                                <option disabled class="option_item_disabled">{{ classroom.faculty_name }}</option>
                            {% endif %}
                                <option value="{{ classroom.id }}"{% if classroom.id == lecture.ClassroomId %} selected{% endif %}>{{ classroom.Name }}</option>
                            {% set previous_faculty = classroom.faculty_id %}
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label class="control-label" for="date">Data</label>
                    <div class="input-group input-append date datepick">
                        <input type="text" class="form-control" name="date"
                               data-fv-notempty="true"
                               data-fv-notempty-message="Data yra privaloma"
                               data-fv-date="true"
                               data-fv-date-format="YYYY-MM-DD"
                               data-fv-date-message="Neteisingo formato data"
                               title="data"
                               value="{{ lecture.Date }}"
                        />
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label for="time_start">Pradžios laikas</label>
                    <input type="time" class="form-control" name="time_start" id="time_start" required value="{{ lecture.TimeStart|date('H:i') }}" placeholder="23:59"/>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label for="time_end">Pabaigos laikas</label>
                    <input type="time" class="form-control" name="time_end" required value="{{ lecture.TimeEnd|date('H:i') }}" placeholder="23:59"/>
                </div><!-- /.form-group -->

            </div><!-- /.col-md-6 -->

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="comment">Komentaras (visiem matomas)</label>
                    <textarea class="form-control" rows="5" name="comment">{{ lecture.Notes }}</textarea>
                </div><!-- /.form-group -->
                
                <div class="form-group">
                    <label for="canceled">Paskaita nevyks</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="canceled" value="{{ lecture.IsCanceled }}"{% if lecture.IsCanceled == 1 %} checked{% endif %}>Taip
                        </label>
                    </div><!--/.checkbox-->
                </div><!-- /.form-group -->

            </div><!-- /.col-md-6 -->

        </div>
    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#lecture-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
        <button type="button" class="btn btn-sm btn-danger" data-comfirm="Ar tikrai norite ištrinti šią paskaitą?"
                onclick='deleteRecord("{{ baseUrl() }}","lecture","LectureId", "{{ lecture.LectureId }}")'>Ištrinti
        </button>
    </div>
</form>
<script>
    colorRequiredFormValidation();

    /*DatePicker*/
    $(document).ready(function() {
        $('.datepick')
            .datepicker({
                startDate: '2010-01-01',
                endDate: '2030-12-31',
                language: "lt",
                calendarWeeks: true
            })
            .on('changeDate', function(e) {
                // Revalidate the date field
                $('#dateRangeForm').formValidation('revalidateField', 'date');
            });
        });
</script>
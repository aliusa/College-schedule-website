<!--@formatter:off-->
<form role="form" method="POST" id="schedule-layout">
    <input type="hidden" name="action" value="edit"/>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="semester">Semestras</label>
                    <select class="form-control select2" name="semester" id="semester">
                        <option disabled selected> -- pasirinkite  -- </option>
                        {% for semester in semesters %}
                            <option value="{{ semester.SemesterId }}"{% if semester.SemesterId == schedule.SemesterId %} selected{% endif %}>{{ semester.Name }}</option>
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label for="subject">Dalykas</label>
                    <select class="form-control select2" name="subject" id="subject">
                        <option disabled selected> -- pasirinkite  -- </option>
                        {% for subject in subjects %}
                            <option value="{{ subject.SubjectId }}"{% if subject.SubjectId == schedule.SubjectId %} selected{% endif %}>{{ subject.Name }}</option>
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->

            <div class="col-md-6">
                
                <div class="form-group">
                    <label for="professor">Dėstytojas</label>
                    <select class="form-control select2" name="professor" id="professor">
                        {% for professor in professors %}
                            <option value="{{ professor.id }}"{% if professor.id == schedule.ProfessorId %} selected{% endif %}>{{ professor.Name }}</option>
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->
                
                <div class="form-group">
                    <label for="is_chosen">Modulis pasirenkamasis</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_chosen" value="{{ schedule.IsChosen }}"{% if schedule.IsChosen == 1 %} checked{% endif %}>Taip
                        </label>
                    </div><!--/.checkbox-->
                </div><!-- /.form-group -->
            </div><!-- /.col-md-6 -->
        </div>
    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#schedule-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
        <button type="button" class="btn btn-sm btn-danger" data-comfirm="Ar tikrai norite ištrinti šią paskaitą?"
                onclick='deleteRecord("{{ baseUrl() }}","recurringtask","RecurringTaskId", "{{ schedule.RecurringTaskId }}")'>Ištrinti
        </button>
    </div>
</form>
<script>
    colorRequiredFormValidation();
</script>
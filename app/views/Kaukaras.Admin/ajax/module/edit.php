<!--@formatter:off-->
<form role="form" method="POST" id="module-layout">
    <input type="hidden" name="action" value="edit"/>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="semester">Semestras</label>
                    <select class="form-control select2" name="semester" id="semester">
                        {% for semester in semesters %}
                            <option value="{{ semester.SemesterId }}"{% if semester.SemesterId == module.SemesterId %} selected{% endif %}>{{ semester.Name }}</option>
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->

            <div class="col-md-6">
                <div class="form-group">
                    <label for="subject">Dalykas</label>
                    <select class="form-control select2" name="subject" id="subject">
                        {% for subject in subjects %}
                            <option value="{{ subject.SubjectId }}"{% if subject.SubjectId == module.SubjectId %} selected{% endif %}>{{ subject.Name }}</option>
                        {% endfor %}
                    </select>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="credits">Kreditai</label>
                    <div class="input-group">
                        <span class="input-group-addon">#</span>
                        <input class="form-control" type="number" min="0" max="10" name="credits" required
                           style="width: 100%;" id="credits" value="{{ module.Credits }}"/>
                    </div>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->
        </div>

        <div class="row">
            <table id="selectedSubcluster" class="table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Grupė/Pogrupis</th>
                        <th>Pasirenkamasis</th>
                    </tr>
                </thead>
                <tbody>
                    {% for subcluster in subclusters %}
                        <tr>
                            <td>{{ subcluster.Name }}</td>
                            <td><label><input type="checkbox" name="is_chosen_{{ subcluster.SubClusterId }}" {% if subcluster.IsChosen != 0 %} checked{% endif %} />
                                    <input type="hidden" name="is_chosen_hidden[]" value="{{ subcluster.SubClusterId }}"/>
                                    Taip</label></td>
                        </tr>
                    {% endfor %}
                </tbody>
                <tfoot>
                    <tr>
                        <th>Grupė/Pogrupis</th>
                        <th>Pasirenkamasis</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#module-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>
</form>
<script>
    colorRequiredFormValidation();
</script>
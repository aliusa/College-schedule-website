<!--@formatter:off-->
<form role="form" method="POST" id="professor-layout">
    <input type="hidden" name="action" value="add"/>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Vardas</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-male"></i>
                    </div>
                    <input type="text" class="form-control" id="name" name="FirstName" autofocus
                       placeholder="" required pattern=".{2,255}" title="Nuo 2 iki 60 ilgis"
                       autocomplete="on"/>
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
                       placeholder="" required pattern=".{2,255}" title="Nuo 2 iki 60 ilgis"/>
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
                    <input type="text" class="form-control" id="email" name="email" placeholder=""/>
                </div>
            </div><!-- /.form-group -->

            <div class="form-group">
                <label for="degree">Mokslinis laipsnis</label>
                <select class="form-control select2" name="degree" id="degree">
                    <option disabled> -- pasirinkite --</option>
                    {% for degree in degries %}
                    <option value="{{ degree.OptionsDetailsId }}">{{ degree.Name }}</option>
                    {% endfor %}
                    <option value="0" selected>Neturi laipsnio</option>
                </select>
            </div><!-- /.form-group -->
        </div><!-- /.col -->

        <div class="col-md-6">
            <div class="form-group">
                <label for="notes">Papildoma informacija</label>
                                        <textarea class="form-control" rows="5" name="notes"
                                                  id="notes"></textarea>
            </div><!-- /.form-group -->
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="semesters">Dirba semestrus</label><br/>
                <select class="form-control select2 multiselect" name="semesters[]" id="semesters" multiple>
                    {% if semesters is empty %}
                    <option disabled>Nėra sukurtų semestrų</option>
                    {% else %}
                        {% for semester in semesters %}
                            <option value="{{ semester.SemesterId }}">{{ semester.Name }}</option>
                        {% endfor %}
                    {% endif %}
                </select>
            </div><!-- /.form-group -->
        </div><!--/.col-md-6-->

    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#professor-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>

</form>
<script type="text/javascript">
    colorRequiredFormValidation();

    $('.multiselect').multiselect({
            maxHeight: 300,
            enableFiltering: true,
            filterPlaceholder: 'Ieškoti...',
            nonSelectedText: 'Pasirinkite',
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '250px'
        });
</script>
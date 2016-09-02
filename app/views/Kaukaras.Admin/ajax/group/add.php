<!--@formatter:off-->
<form role="form" method="POST" id="group-layout">
    <input type="hidden" name="action" value="add"/>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Pavadinimas</label>
                <input type="text" class="form-control" id="name" name="name" autofocus
                       autocomplete="on"
                       data-fv-notempty="true"
                       data-fv-notempty-message="Pavadinimas neturi būti tuščias"
                       data-fv-regexp="true"
                       data-fv-regexp-regexp="^[a-zA-Z0-9\-]+$"
                       data-fv-regexp-message="Pavadinime privalo būti tik raidės ir/arba skaičiai"
                       data-fv-stringlength="true"
                       data-fv-stringlength-min="3"
                       data-fv-stringlength-max="10"
                       data-fv-stringlength-message="Pavadinimo ilgis privalo būti nuo 3 iki 30 simbolių ilgio"
                       title="Nuo 3 iki 30 ilgis"/>
            </div><!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">El.paštas</label>
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="text" class="form-control" id="email" name="email"
                       placeholder="" pattern=".{5,30}" title="Nuo 5 iki 20 ilgis"/>
                </div>
            </div><!-- /.form-group -->
        </div><!-- /.col -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="fieldId">Studijų pavadinimas</label>
                <select class="form-control select2" name="fieldId" style="width: 100%;" id="fieldId">
                    {% for field in fields %}
                    <option value="{{ field.OptionsDetailsId }}">{{ field.Name }}</option>
                    {% endfor %}
                </select>
            </div><!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="formId">Studijų forma</label>
                <select class="form-control select2" name="formId" id="formId">
                    {% for form in forms %}
                    <option value="{{ form.OptionsDetailsId }}">{{ form.Name }}</option>
                    {% endfor %}
                </select>
            </div><!-- /.form-group -->
        </div><!-- /.col -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="facultyId">Skyrius</label>
                <select class="form-control select2" name="facultyId" id="facultyId">
                    {% for faculty in faculties %}
                        <option value="{{ faculty.FacultyId }}">{{ faculty.Name }}</option>
                    {% endfor %}
                </select>
            </div><!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="startYear">Įstojimo metai</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">#</span>
                    <input type="number" class="form-control"
                           placeholder="0000" id="startYear" name="startYear" required
                           min="2000" max="2050"
                           aria-describedby="basic-addon1">
                </div>
            </div><!-- /.form-group -->
        </div>
    </div><!-- /.row -->
        <div class="col-md-12">
            <table id="addingSubclusterList" class="table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Pavadinimas</th>
                    <th>Veiksmas</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Pavadinimas</th>
                    <th>Veiksmas</th>
                </tr>
                </tfoot>
                <button type="button" class="btn btn-sm btn-default pull-right" aria-label="Left Align" id="addSubcluster">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Pridėti pogrupį
                </button>
            </table>
        </div><!--/.col-md-12-->
    <div class="row">

    </div><!--/.row-->

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#group-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>

</form>
<script type="text/javascript">
    $(document).ready(function() {

        colorRequiredFormValidation();

        // convert table to Datatable
        $('#addingSubclusterList').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": true
        });

        // Delete first generated row
        document.getElementById("addingSubclusterList").deleteRow(1);

        $('#addSubcluster').click(function() {
            var cell1 = '<input type="text" name="subclusters[]" class="form-control" placeholder="Įveskite pogrupio pav."' +
                ' pattern=".{1,50}" data-fv-stringlength-min="1" data-fv-stringlength-max="50"/>';
            var cell2 = '<button type="button" class="btn btn-sm btn-default removeSubcluster" aria-label="Left Align"> ' +
                '<span class="glyphicon glyphicon-remove" aria-hidden="true"> Pašalinti</span>' +
                '</button>';

            // Adds table row.
            $('#addingSubclusterList').append('<tr><td>' + cell1 + '</td><td>' + cell2 + '</td></tr>');
        });

        // Listen for button Remove in subcluster list
        $('#addingSubclusterList').on('click', '.removeSubcluster',  function(e) {
            // Find nearest table row
            var whichtr = $(this).closest("tr");
            // Remove row
            whichtr.remove();
        });
    });
</script>
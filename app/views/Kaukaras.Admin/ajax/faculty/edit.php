<!--@formatter:off-->
<form role="form" method="POST" id="field-layout">
    <input type="hidden" name="action" value="edit"/>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Pavadinimas</label>
                    <input type="text" class="form-control" id="name" name="name"
                           autocomplete="on" placeholder="" required pattern=".{3,255}"
                           title="Nuo 3 iki 255 ilgis" value="{{ faculty.Name }}"/>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->
        </div>
    </div>

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#field-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>

        <button type="button" class="btn btn-sm btn-danger"
                data-comfirm="Ar tikrai norite ištrinti šį skyrių"
                onclick='deleteRecord("{{ baseUrl() }}","faculty","FacultyId", "{{ faculty.FacultyId }}")'>Ištrinti
        </button>
    </div>
</form>
<script>
    colorRequiredFormValidation();
</script>
<form role="form" method="POST" id="subject-layout">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Pavadinimas</label>
                        <input type="text" class="form-control" id="name" name="name" autofocus
                               autocomplete="on" placeholder="" required pattern=".{3,255}"
                               title="Nuo 3 iki 255 ilgis"/>
                    </div><!-- /.form-group -->
                </div>
            </div><!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <label>Dalykas nebeskaitomas</label>
                    <label style="display: block;margin-top: 6px">
                        <input type="checkbox" name="isnt_active" value="0"/>Taip
                    </label>
                </div>
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.box-body -->

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success" onclick="submitForm('#subject-layout', function(data){
			//var link = 'api/public/group'/*+data.pk*/;
			//window.open(link, '_self');
		});">Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>
</form>
<script type="text/javascript">
    colorRequiredFormValidation();
</script>
<form role="form" method="POST" id="hardware-layout">
    <input type="hidden" name="action" value="add"/>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="name">Pavadinimas</label>
                <input type="text" class="form-control" id="name" name="name" autofocus required autocomplete="on"
                       data-fv-notempty-message="Pavadinimas neturi būti tuščias"/>
            </div><!-- /.form-group -->
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="equipment" id="equipment_hardware" value="1" checked>
                        Techninė įranga
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="equipment" id="equipment_software" value="2">
                        Programinė įranga
                    </label>
                </div>
            </div>
        </div
    </div><!-- /.row -->

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success"
                onclick="submitForm('#hardware-layout', function(data){});">
            Išsaugoti
        </button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal()">Atšaukti</button>
    </div>

</form>
<script type="text/javascript">
    colorRequiredFormValidation();
</script>
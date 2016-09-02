<!--@formatter:off-->
<form role="form" method="POST" id="classroom-layout">
    <input type="hidden" name="action" value="add"/>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#mainInfoAdding">Pagrindinė informacija</a></li>
        <li><a href="#hardware_software">Įranga</a></li>
    </ul>

    <div class="modal-body">
        <div class="tab-content">
            <div class="tab-pane active" id="mainInfoAdding">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Pavadinimas</label>
                            <input type="text" class="form-control" id="name" name="name" autofocus required autocomplete="on"
                                   data-fv-notempty-message="Pavadinimas neturi būti tuščias"/>
                        </div><!-- /.form-group -->
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vacancy">Vietų sk</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input class="form-control" type="number" min="0" max="1000" name="vacancy" id="vacancy"/>
                            </div>
                        </div><!-- /.form-group -->
                    </div><!-- /.col -->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facultyId">Skyrius</label>
                            <select class="form-control select2" name="facultyId" id="facultyId">
                                <option disabled selected> -- pasirinkite --</option>
                                {% for faculty in faculties %}
                                    <option value="{{ faculty.FacultyId }}">{{ faculty.Name }}</option>
                                {% endfor %}
                                <option value="0">Nepriklauso skyriui</option>
                            </select>
                        </div><!-- /.form-group -->
                    </div>
                </div><!-- /.row -->
            </div>

            <div class="tab-pane" id="hardware_software">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hardware">Techn. įranga</label>
                            <select class="form-control select2" name="hardware[]" id="hardware" multiple size="10">
                                {% if hardware is empty %}
                                    <option disabled>Nėra sukurtos techn. įrangos</option>
                                {% else %}
                                    {% for hardware_item in hardware %}
                                        <option value="{{ hardware_item.EquipmentId }}">{{ hardware_item.Name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div><!-- /.form-group -->
                    </div><!--/.col-md-6-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="software">Progr. įranga</label>
                            <select class="form-control select2" name="software[]" id="software" multiple size="10">
                                {% if software is empty %}
                                    <option disabled>Nėra sukurtos progr. įrangos</option>
                                {% else %}
                                    {% for software_item in software %}
                                        <option value="{{ software_item.EquipmentId }}">{{ software_item.Name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div><!-- /.form-group -->
                    </div><!--/.col-md-6-->
                </div><!-- /.row -->
            </div><!--/.tab-pane-->
        </div><!--/.tab-content-->
    </div><!--/.modal-body-->

    <div class="modal-footer" style="padding:0px;border:0px;">
        <button type="button" class="btn btn-sm btn-success"
                onclick="submitForm('#classroom-layout', function(data){});">
            Išsaugoti
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

    <!-- Initialize multiple select checkbox plugin: -->
    $(document).ready(function() {
        $('#hardware').multiselect({
            maxHeight: 300,
            enableFiltering: true,
            filterPlaceholder: 'Ieškoti...',
            numberDisplayed: 1,
            nonSelectedText: 'Pasirinkite'
        });
        $('#software').multiselect({
            maxHeight: 300,
            enableFiltering: true,
            filterPlaceholder: 'Ieškoti...',
            numberDisplayed: 1,
            nonSelectedText: 'Pasirinkite'
        });
    });
</script>
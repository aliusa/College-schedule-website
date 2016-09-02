<!--@formatter:off-->
<form role="form" method="POST" id="module-layout">
    <input type="hidden" name="action" value="add"/>

    <div class="modal-body">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="subclusters">Pogrupiai</label>
                    <select class="form-control select2" name="subclusters[]" id="subclusters" multiple>
                        {% if subclusters is empty %}
                            <option disabled>Nėra sukurtų pogrupių</option>
                        {% else %}
                            {% for subcluster in subclusters %}
                                <option value="{{ subcluster.id }}">{{ subcluster.Name }}</option>
                            {% endfor %}
                        {% endif %}
                    </select>
                </div><!-- /.form-group -->
            </div><!--/.col-md-6-->

            <table id="selectedSubcluster" class="table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Grupė/Pogrupis</th>
                        <th>Pasirenkamasis</th>
                    </tr>
                </thead>
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

    <!-- Initialize multiple select checkbox plugin: -->
    $(document).ready(function() {
        $('#selectedSubcluster').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": true
        });

        document.getElementById("selectedSubcluster").deleteRow(1);

        $('#subclusters').multiselect({
            maxHeight: 300,
            enableFiltering: true,
            filterPlaceholder: 'Ieškoti...',
            nonSelectedText: 'Pasirinkite',
            buttonWidth: '250px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(option, checked) {

                // Check if item drop down was selected
                if (checked) {
                    // Adds table row.
                    var cell2 = option.text();
                    var cell3 = '<label><input type="checkbox" name="is_chosen_' + option.val() + '" /></label>';

                    $('#selectedSubcluster').append('<tr><td>' + cell2 + '</td><td>' + cell3 + '</td></tr>')
                } else {
                    // Item was deselected. Remove item from table.

                    var table = document.getElementById("selectedSubcluster");

                    // Iterates table rows.
                    for (var r = 0, n = table.rows.length; r < n; r++) {
                        // Matches first ID cell.
                        if (r = table.rows[r].cells[0].innerHTML) {
                            // Deletes row.
                            table.deleteRow(1);
                        }
                    }


                }
            }
        });

    });
</script>
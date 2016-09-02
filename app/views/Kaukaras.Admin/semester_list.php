<!--@formatter:off-->
{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'OPTIONS'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span>Semestrai</span>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        <a href="javascript:void(0);" class="btn btn-sm reorder_link btn-default" id="save_reorder"
                           data-reorder-records="semesters">Išrikiuot sąrašą</a>
                        <div id="reorder-helper" class="light_box" style="display:none;">1. Temkite sąrašo elementus
                            aukštyn arba žemyn, kad juos perrikiuotumėte.
                            <br>2. Spauskit "Išsaugoti" sąrašo rikiavimui išsaugoti.
                        </div>
                        <div class="list">
                            <ul class="reorder_ul reorder-photos-list">
                                {% for semester in semesters %}
                                    <li id="image_li_{{semester.SemesterId}}" class="ui-sortable-handle">
                                        <a href="javascript:void(0);">{{ semester.Name }}</a>
                                        <a href="#" class="btn btn-warning btn-xs modalwin"
                                           data-modal-url="{{ urlFor('ajax/semester/edit', {'id':semester.SemesterId}) }}"
                                           data-modal-action="edit"
                                           data-modal-title="Redaguoti semestrą"
                                           data-modal-width="700px"><i class="glyphicon glyphicon-pencil"></i> <span class="hidden-480">Redaguoti</span></a>
                                    </li>
                                {% endfor %}
                            </ul>
                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
{% include 'Kaukaras.Admin/footer.php' %}

<script>
    $(document).ready(function () {
    $('.reorder_link').on('click', function () {
        $("ul.reorder-photos-list").sortable({tolerance: 'pointer'});
        $('.reorder_link').html('Išsaugoti');
        $('.reorder_link').attr("id", "save_reorder");
        $('#reorder-helper').slideDown('slow');
        $('.image_link').attr("href", "javascript:void(0);");
        $('.image_link').css("cursor", "move");
        $("#save_reorder").click(function (e) {
            if (!$("#save_reorder i").length) {
                $(this).html('').prepend('<img src="{{ baseUrl() }}/static/images/refresh-animated.gif"/>');
                $("ul.reorder-photos-list").sortable('destroy');
                $("#reorder-helper").html("Išsaugomas sąrašas - tai gali užtrukti, neišjunkit naršyklės lango.")
                    .removeClass('light_box').addClass('notice notice_error');
                var h = [];
                $("ul.reorder-photos-list li").each(function () {
                    /*Grabs just id's of records*/
                    h.push($(this).attr('id').substr(9));
                });
                var urlOfPost = "{{ urlFor('ajax/settings/actions/reorder') }}";
                $.ajax({
                    type: "POST",
                    url: urlOfPost,
                    data: {
                        records: $(this).data('reorder-records'),
                        ids: "" + h
                    },
                    success: function (html) {
                        new jBox('Notice', {
                            color: 'green',
                            animation: 'zoomIn',
                            title: 'Išsaugota',
                            autoClose: 3000,
                            stack: false,
                            attributes: {x: 'right', y: 'bottom'},
                            position: {x: 50, y: 50},
                            content: 'Sėkmingai išsaugota'
                        });
                        window.location.reload();
                    }
                });
                return false;
            }
            e.preventDefault();
        });
    });
});
</script>
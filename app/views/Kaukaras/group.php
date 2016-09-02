<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'GROUP'} %}
<div class="page_title"><span>{{ group.Name }}</span></div><br/>
<div>
    <a class="btn btn-warning" id="button_left"
       href="{{ urlFor('group', {'id': group.ClusterId, 'date': lastWeekToday} ) }}"
       role="button"
       style="float: left">Praėjusi sav.</a>
    <a class="btn btn-warning" id="button_right"
       href="{{ urlFor('group', {'id': group.ClusterId, 'date': nextWeekToday} ) }}"
       role="button"
       style="float: right">Kita sav.</a>

    <div class="content_center">

        <!--Calendar picker-->
        <form name="tstest" method="get" style="display: inline;">
            <!--link for date picker-->
            <input type="hidden" value="{{ urlFor('group', {'id': group.ClusterId, 'date': ''} ) }}" name="linkToSelected"/>
            <input type="Text" name="timestamp" value="{{ startDate }}" id="datechange" style="width: 0;border: 0" />
            <a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value,
                document.tstest.linkToSelected.value, '{{ baseUrl() }}');" style="color:black">
                <span>{{ startDate }} — {{ endDate }}</span>
                <i class="fa fa-calendar"></i></a>
        </form>
    </div>
</div>
<table class="table table-bordered table-condensed table-hover">
    <tbody>
        {% for schedule_item in schedule %}
            <tr>
                <td colspan="3" class="header_row">{{ schedule_item.weedayName }} ({{ schedule_item.date }})</td>
            </tr>

            {% if schedule_item.group is empty %}
                <tr>
                    <td></td>
                    <td class="content_center">-</td>
                    <td></td>
                </tr>
            {% else %}
                {% for lecture in schedule_item.group %}
                    <tr>
                        <td class="content_center sidepanel_left">
                            {{ lecture.TimeStart }} - {{ lecture.TimeEnd }}
                        </td>
                        <td class="content_center">
                            <b><a href="{{ urlFor('subject', {'id':lecture.SubjectId}) }}">
                                    {{lecture.SubjectName }}</a></b>
                            {% if lecture.OccursEvery > 1 %}(kas {{ lecture.OccursEvery }} sav.){% endif %}
                            {% if lecture.IsChosen != empty %}*{% endif %}<br/>
                            <b><a href="{{ urlFor('professor', {'id': lecture.ProfessorId}) }}"
                                  style="color:black">
                                {{ lecture.professor}}</a></b>
                            {% if lecture.subcluster_name != '0' %}
                                <br/><b>({{ lecture.subcluster_name }} pogr.)</b>
                            {% endif %}
                            
                            <!-- Other groups having same lecture-->
                            {% if lecture.with != empty %}
                                {% for cluster in lecture.with %}
                                    <br/>su {{ cluster.Name }}
                                {% endfor %}
                            {% endif %}
                            {% if lecture.IsCanceled == 1 %}<br/><span style="color:red;font-weight: bold">Paskaitos nebus</span>{% endif %}
                            {% if lecture.Notes != empty %}<br/><span>{{ lecture.Notes }}</span>{% endif %}
                        </td>
                        <td class="content_center sidepanel_right">
                            <a href="{{ urlFor('classroom', {'id': lecture.ClassroomId}) }}">{{ lecture.ClassroomName }}</a>
                        </td>
                    </tr>
                {% endfor %}
            {% endif %}
        {% endfor %}
    </tbody>
</table>
{% include 'Kaukaras/footer_anotations.php' %}
<script>
    keypressNavigation();
</script>
{% include 'Kaukaras/footer.php' %}
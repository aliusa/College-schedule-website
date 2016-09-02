<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'SUBJECT'} %}
<div class="page_title"><span>{{ subject.Name }}</span></div>
<br/>
<div>
    <a class="btn btn-warning" id="button_left"
       href="{{ urlFor('subject', {'id':subject.SubjectId, 'date':lastWeekToday}) }}"
       role="button"
       style="float: left">Praėjusi sav.</a>
    <a class="btn btn-warning" id="button_right"
       href="{{ urlFor('subject', {'id':subject.SubjectId, 'date':nextWeekToday}) }}"
       role="button"
       style="float: right">Kita sav.</a>

    <div class="content_center">
        <!--Calendar picker-->
        <form name="tstest" method="get" style="display: inline;">
            <!--link for date picker-->
            <input type="hidden" value="{{ urlFor('subject', {'id': subject.SubjectId, 'date': ''} ) }}" name="linkToSelected"/>
            <input type="Text" name="timestamp" id="datechange" value="{{ startDate }}" style="width: 0;border: 0" />
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
                            {{ lecture.TimeStart|slice(0,5) }} - {{ lecture.TimeEnd|slice(0,5) }}
                        </td>
                        <td class="content_center">
                            <b><a href="{{ urlFor('professor', {'id':lecture.ProfessorId}) }}">{{lecture.ProfessorName }}</a></b><br/>
                            <span><a href="{{ urlFor('group', {'id':lecture.ClusterId}) }}">{{ lecture.Name }}</a></span>
                            {% if lecture.IsChosen != empty %}*{% endif %}
                            {% if lecture.OccursEvery > 1 %}
                                (kas {{ lecture.OccursEvery }} sav.)
                            {% endif %}
                            {% if lecture.IsCanceled == 1 %}<br/><span style="color:red;font-weight: bold">Paskaitos nebus</span>{%endif%}
                            {% if lecture.Notes is not empty %}<br/> {{ lecture.Notes }}{% endif %}

                            <!-- Other groups having same lecture -->
                            {% for group in lecture.with %}
                                <br/>
                                <a href="{{ urlFor('group', {'id':group.ClusterId}) }}">{{ group.Name }}</a>
                                {% if group.IsChosen != empty %}*{% endif %}
                                {% if group.OccursEvery > 1 %}
                                    (kas {{ group.OccursEvery }} sav.)
                                {% endif %}
                                {% if group.IsCanceled == 1 %}<br/><span style="color:red;font-weight: bold">Paskaitos nebus</span>{%endif %}
                                {% if group.Notes is not empty %}<br/> {{ group.Notes }}{% endif %}
                            {% endfor %}
                        </td>
                        <td class="content_center sidepanel_right">
                            <a href="{{ urlFor('classroom', {'id': lecture.ClassroomId}) }}">{{ lecture.ClassroomName }}
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
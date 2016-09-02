<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'SUBJECT'} %}
<table class="table table-bordered table-condensed">
    <tr>
        <td class="header_row">Dalykai</td>
    </tr>
    <tr>
        <td class="content_center">
            {% if subjects is empty %}
                <span class="tbl_error_string">Nėra įtrauktų dalykų!</span>
            {% else %}
                {% for subject in subjects %}
                    {% if subject.Name|slice(0,1) != previousLetter %}
                        <a href="#index_{{ subject.Name|slice(0,1) }}">{{ subject.Name|slice(0,1) }}</a>
                    {% endif %}
                    {% set previousLetter = subject.Name|slice(0,1) %}
                {% endfor %}
                <hr/>
                {% for subject in subjects %}
                    {% if subject.Name|slice(0,1) != previousLetter %}
                        {% if previousLetter is not null %}
                            </div>
                        {% endif %}
                        <div class="letter_group" id="index_{{ subject.Name|slice(0,1) }}">
                        <h5>{{ subject.Name|slice(0,1) }}</h5>
                    {% endif %}
                    <a href="{{ urlFor('subject', {'id':subject.SubjectId}) }}">{{ subject.Name }}</a><br/>
                    {% set previousLetter = subject.Name|slice(0,1) %}
                {% endfor %}
            {% endif %}
        </td>
    </tr>
</table>
{% include 'Kaukaras/footer.php' %}
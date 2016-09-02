<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'PROFESSOR'} %}
<table class="table table-bordered table-condensed">
    <tr>
        <td class="header_row">Dėstytojai</td>
    </tr>
    <tr>
        <td class="content_center">
            {% if professors is empty %}
                <span class="tbl_error_string">Nėra įtrauktų dėstytojų!</span>
            {% else %}
                {% for professor in professors %}
                    {% if professor.LastName|slice(0,1) != previousLetter %}
                        <a href="#index_{{ professor.LastName|slice(0,1) }}">{{ professor.LastName|slice(0,1) }}</a>
                    {% endif %}
                    {% set previousLetter = professor.LastName|slice(0,1) %}
                {% endfor %}
                <hr/>
                {% for professor in professors %}
                    {% if professor.LastName|slice(0,1) != previousLetter %}
                        {% if previousLetter is not null %}
                            </div>
                        {% endif %}
                        <div class="letter_group" id="index_{{ professor.LastName|slice(0,1) }}">
                        <h5>{{ professor.LastName|slice(0,1) }}</h5>
                    {% endif %}
                    <a href="{{ urlFor('professor', {'id': professor.ProfessorId}) }}">
                        {{ professor.FirstName|slice(0,1) }}. {{professor.LastName }}</a>{% if professor.DegreeName is
                            not null %}, {{ professor.DegreeName }}{% endif %}<br/>
                    {% set previousLetter = professor.LastName|slice(0,1) %}
                {% endfor %}
            {% endif %}
        </td>
    </tr>
</table>
{% include 'Kaukaras/footer.php' %}
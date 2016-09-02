<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'CLASSROOM'} %}
{% if faculties is empty %}
<p>Nėra sukurtų auditorijų.</p>
{% else %}
    <table class="table table-bordered table-condensed header_center content_center">
        {% set facultyCount = faculties|length %}
        <thead>
            <tr>
                {% for faculty in faculties %}
                {% if faculty.Name is empty %}
                <th class="header_row">kita</th>
                {% else %}
                <th class="header_row">{{ faculty.Name }}</th>
                {% endif %}
                {% endfor %}
            </tr>
        </thead>
        <tbody>
            <tr>
                {% for key1,faculty in faculties %}
                    <td>
                        {% for classroom in faculty.classrooms %}
                        <a href="{{ urlFor('classroom', {'id': classroom.ClassroomId}) }}">{{ classroom.Name }}</a><br/>
                        {% endfor %}
                    </td>
                {% endfor %}
            </tr>
        </tbody>
    </table>
{% endif %}
{% include 'Kaukaras/footer.php' %}
<!--@formatter:off-->
{% include 'Kaukaras/header.php' with {'page':'GROUP'} %}
{% if faculties is empty %}
    <p>Nėra sukurtų fakultetų.</p>
{% else %}
{% for faculty in faculties %}
        <div style="overflow: auto;">
            <table class="table table-bordered table-condensed header_center content_center">
                <tbody>
                    <tr>
                        <td class="header_row" colspan="{{ faculty.fields|length }}">{{ faculty.Name }}</td>
                    </tr>
                    <tr>
                        {% if faculty.fields is empty %}
                            <td><span class="tbl_error_string">Nėra įtrauktų grupių!</span></td>
                        {% else %}
                        {% for field in faculty.fields %}
                                <td>
                                    <b>{{ field.Name }}</b>
                                    <br/>
                                    {% for group in field.groups %}
                                    <a href="{{ urlFor('group', {'id':group.ClusterId}) }}">{{ group.Name }}</a><br/>
                                    {% endfor %}
                                </td>
                            {% endfor %}
                        {% endif %}
                    </tr>
                </tbody>
            </table>
        </div>
    {% endfor %}
{% endif %}
{% include 'Kaukaras/footer.php' %}
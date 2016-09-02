<!--@formatter:off-->
<ul>
    <li><a target="_blank"
           href="{{ urlFor('professor', {'id':lecture.ProfessorId, 'date':lecture.Date}) }}">Dėstytojas</a></li>
    <li><a target="_blank" href="{{ urlFor('group', {'id':lecture.ClusterId, 'date':lecture.Date}) }}">Grupė</a></li>
    <li><a target="_blank" href="{{ urlFor('subject', {'id':lecture.SubjectId, 'date':lecture.Date}) }}">Dalykas</a>
    </li>
    <li><a target="_blank"
           href="{{ urlFor('classroom', {'id':lecture.ClassroomId, 'date':lecture.Date}) }}">Auditorija</a></li>
</ul>
<!--@formatter:off-->
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true" style="margin-left: 30px">
            Naujas
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Nauja tvarkaraščio kortelė" data-modal-width="700px"
                   data-modal-url="{{ urlFor('ajax/recurringtask/add') }}">Tvarkaraštis</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Naujas modulis"  data-modal-width="600px"
                   data-modal-url="{{ urlFor('ajax/module/add') }}">Modulis</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Nauja grupė"  data-modal-width="700px"
                   data-modal-url="{{ urlFor('ajax/group/add') }}">Grupė</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Naujas dėstytojas"  data-modal-width="700px"
                   data-modal-url="{{ urlFor('ajax/professor/add') }}">Dėstytojas</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Naujas dalykas"  data-modal-width="500px"
                   data-modal-url="{{ urlFor('ajax/subject/add') }}">Dalykas</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Naujas semestras"  data-modal-width="500px"
                   data-modal-url="{{ urlFor('ajax/semester/add') }}">Semestras</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Nauja auditorija"  data-modal-width="700px"
                   data-modal-url="{{ urlFor('ajax/classroom/add') }}">Auditorija</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Naujas skyrius"  data-modal-width="400px"
                   data-modal-url="{{ urlFor('ajax/faculty/add') }}">Skyrius</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Nauja studijų programa"  data-modal-width="500px"
                   data-modal-url="{{ urlFor('ajax/field/add') }}">Studijų programa</a></li>
            <li><a href="#" class="modalwin" data-modal-action="add" data-modal-title="Nauja įranga"  data-modal-width="400px"
                   data-modal-url="{{ urlFor('ajax/equipment/add') }}">Įranga</a></li>
        </ul>
    </div>

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Meniu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{% if page == 'INDEX' %}active{% endif %}">
                <a href="{{ urlFor('admin/index') }}"><i class="fa fa-tachometer"></i><span>Pagrindinis</span></a></li>
            <li {% if page=='GROUPS' %}class="active" {% endif %}><a href="{{ urlFor('admin/group') }}">
                    <i class="fa fa-group" aria-hidden="true"></i><span>Grupės</span></a></li>
            <li {% if page=='PROFESSORS' %}class="active" {% endif %}><a href="{{ urlFor('admin/professor') }}">
                    <i class="fa fa-male" aria-hidden="true"></i><span>Dėstytojai</span></a></li>
            <li {% if page=='SUBJECTS' %}class="active" {% endif %}><a href="{{ urlFor('admin/subject') }}">
                    <i class="fa fa-cubes" aria-hidden="true"></i><span>Dalykai</span></a></li>
            <li {% if page=='SCHEDULES' %}class="active" {% endif %}><a href="{{ urlFor('admin/module') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i><span>Moduliai</span></a></li>
            <li class="treeview{% if page == 'OPTIONS' %} active{% endif %}">
                <a href="#"><i class="fa fa-wrench" aria-hidden="true"></i> <span>Nustatymai</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ urlFor('admin/semester') }}"><i class="fa fa-archive" aria-hidden="true"></i>Semestrai</a></li>
                    <li><a href="{{ urlFor('admin/classroom') }}"><i class="fa fa-briefcase" aria-hidden="true"></i>Auditorijos</a></li>
                    <li><a href="{{ urlFor('admin/faculty') }}"><i class="fa fa-university" aria-hidden="true"></i>Skyriai</a></li>
                    <li><a href="{{ urlFor('admin/field') }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Studijų programos</a></li>
                    <li><a href="{{ urlFor('admin/user') }}"><i class="fa fa-user" aria-hidden="true"></i>Personalas</a></li>
                    <li><a href="{{ urlFor('admin/equipment') }}"><i class="fa fa-hdd-o" aria-hidden="true"></i>Įranga</a></li>
                </ul>
            </li>
            <li class="header">KITA</li>
            <li {% if page=='HELP' %}class="active" {% endif %}><a href="{{ urlFor('admin/help') }}">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><span>Documentacija</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
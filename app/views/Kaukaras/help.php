{% include 'Kaukaras/header.php' with {'page':'HELP'} %}
<div class="panel panel-default">

    <!-- List group -->
    <ul class="list-group">
        <li class="list-group-item">
            <p><b>Pastebėjote klaidą tvarkaraštyje</b>, rašykite
                <a href="mailto:{{ emailSchoolHelp }}?Subject=Tvarkaraščio%20IS"
                   target="_top">{{ emailSchoolHelp }}</a>
            </p>
        </li>
        <li class="list-group-item">
            <b>Turite pasiūlymų sistemos tobulinimui ar pastebėjote sistemoje klaidą</b>, rašykite
            <a
                href="mailto:{{ adminEmail }}?Subject=Tvarkaraščio%20IS"
                target="_top">{{ adminEmail }}</a>
        </li>
    </ul>

    <div class="panel-heading">
        Autorius: <a href="mailto:{{ adminEmail }}?Subject=Tvarkaraščio%20IS"
                     target="_top">{{ adminName }}</a>
        @2015-2016
    </div>

</div>
{% include 'Kaukaras/footer.php' %}
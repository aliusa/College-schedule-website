<!DOCTYPE html>
<html>
<head lang="lt">
    <title>VKK Tvarkaraštis</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="VKK tvarkaraštis">
    <meta name="keywords"
          content="vkk, tvarkarastis, kaukaras, vilniaus kooperacijos kolegija, schedule, kolegija, paskaitų tvarkaraštis">
    <meta name="author" content="Alius Sultanovas">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">

    <link rel="shortcut icon" href="{{ baseUrl() }}/static/icons/favicon.png" type="image/x-icon">
    <link rel="icon" href="{{ baseUrl() }}/static/icons/favicon.png" type="image/x-icon">

    <script async src="{{ baseUrl() }}/static/plugins/jquery/jquery-2.1.3.min.js" rel="prefetch"></script>

    <!-- Bootstrap -->
    <link href="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script async src="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/js/bootstrap.min.js" rel="prefetch"></script>

    <!-- Custom CSS -->
    <link href="{{ baseUrl() }}/static/css/style.css?v20160610" rel="stylesheet">
    <script async src="{{ baseUrl() }}/static/js/js.js?v20160501"></script>

    <script async src="{{ baseUrl() }}/static/plugins/popupdatepicker/ts_picker.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/font-awesome-4.6.3/css/font-awesome.min.css">
</head>
<body>
<div class="container">

    <div id="header">
        <div class="row">
            <div class="col-md-3">
                <a href="http://www.vkk.lt/" target="_top">
                    <div id="header_pic" class="left-side"></div>
                </a>
            </div>
            <div class="col-md-6">
                <span id="header_text">PASKAITŲ TVARKARAŠČIO INFORMACINĖ SISTEMA</span>
            </div>
        </div>
    </div>

    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ baseUrl() }}" target="_self">VKK</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li {% if page==
                    'GROUP' %}class="active"{% endif %}><a href="{{ baseUrl() }}">Grupės</a></li>
                    <li {% if page==
                    'PROFESSOR' %}class="active"{% endif %}><a href="{{ urlFor('professor_list') }}">Dėstytojai</a></li>
                    <li {% if page==
                    'SUBJECT' %}class="active"{% endif %}><a href="{{ urlFor('subject_list') }}">Dalykai</a></li>
                    <li {% if page==
                    'CLASSROOM' %}class="active"{% endif %}><a
                        href="{{ urlFor('classroom_list') }}">Auditorijos</a></li>
                    <li {% if page==
                    'DAY' %}class="active"{% endif %}><a href="{{ urlFor('day_list') }}">Dienos</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

<!DOCTYPE html>
<html>
<head lang="lt">
    <!-- Title -->
    <title>VKK Tvarkaraštis. Admin</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8"/>
    <meta name="description" content="VKK tvarkaraštis"/>
    <meta name="keywords" content="vkk, tvarkarastis, kaukaras"/>
    <meta name="author" content="Alius Sultanovaas"/>

    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>

    <link rel="shortcut icon" href="{{ baseUrl() }}/static/icons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ baseUrl() }}/static/icons/favicon.ico" type="image/x-icon">

    <!-- jQuery -->
    <script src="{{ baseUrl() }}/static/plugins/jquery/jquery-2.1.3.min.js"></script>
    <!--TODO: move to production-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/css/style.admin.css?v=20160821">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/css/bootstrap.min.css">
    <script src="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/datatables/dataTables.bootstrap.css">
    <script src="{{ baseUrl() }}/static/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ baseUrl() }}/static/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Moment 2.13.0. Required fo datetimepicker/js.js-->
    <script src="{{ baseUrl() }}/static/plugins/moment-2.13.0/moment-with-locales.min.js"></script>

    <!-- DatePicker 1.6.1 https://github.com/eternicode/bootstrap-datepicker-->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/datepicker-1.6.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/datepicker-1.6.1/css/bootstrap-datepicker3.min.css">
    <script src="{{ baseUrl() }}/static/plugins/datepicker-1.6.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ baseUrl() }}/static/plugins/datepicker-1.6.1/locale/bootstrap-datepicker.lt.min.js"></script>

    <script src="{{ baseUrl() }}/static/plugins/datetimepicker/js.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme Styles -->
    <link href="{{ baseUrl() }}/static/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE skin -->
    <link rel="stylesheet" href="{{ baseUrl() }}/static/css/skins/skin-blue.min.css">

    <!-- AdminLTE App -->
    <script src="{{ baseUrl() }}/static/js/app.min.js"></script>
    <script src="{{ baseUrl() }}/static/plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/jBox-0.3.2/css/jBox.css">
    <script src="{{ baseUrl() }}/static/plugins/jBox-0.3.2/js/jBox.js"></script>

    <script src="{{ baseUrl() }}/static/plugins/FormValidation/formValidation.min.js"></script>
    <script src="{{ baseUrl() }}/static/plugins/FormValidation/framework/bootstrap.min.js"></script>
    <script src="{{ baseUrl() }}/static/plugins/FormValidation/language/lt_LT.js"></script>

    <!--Bootbox-->
    <script src="{{ baseUrl() }}/static/plugins/bootbox/bootbox.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- Bootstrap Multiselect 0.9.13 https://github.com/davidstutz/bootstrap-multiselect -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript"
            src="{{ baseUrl() }}/static/plugins/bootstrap-multiselect-0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet"
          href="{{ baseUrl() }}/static/plugins/bootstrap-multiselect-0.9.13/css/bootstrap-multiselect.css"
          type="text/css"/>

    <!-- D3 https://github.com/d3/d3-->
    <script type="text/javascript" src="{{ baseUrl() }}/static/plugins/d3-3.5.17/d3.min.js"></script>

    <script type="text/javascript" src="{{ baseUrl() }}/static/plugins/cal-heatmap-3.6.0/cal-heatmap.min.js"></script>
    <link rel="stylesheet" href="{{ baseUrl() }}/static/plugins/cal-heatmap-3.6.0/cal-heatmap.css"/>

    <!-- Custom JS -->
    <script src="{{ baseUrl() }}/static/js/js.admin.js?v=20160818"></script>
    <script src="{{ baseUrl() }}/static/js/modals.js?v20160519"></script>
    <script src="{{ baseUrl() }}/static/js/datatables.js?v20160603"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">

<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ urlFor('admin/group') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>VKK</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>VKK</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ baseUrl() }}/static/images/rounded-512.png" class="user-image"
                                 alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ user }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <p>
                                    {{ user }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ urlFor('admin/user', {'id': user_id }) }}"
                                       class="btn btn-default btn-flat">Profilis</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ urlFor('admin/logout') }}"
                                       class="btn btn-default btn-flat">Atsijungti</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
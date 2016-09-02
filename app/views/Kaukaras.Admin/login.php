<!DOCTYPE html>
<html>
<head>
    <title>VKK Tvarkaraštis</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <link rel="shortcut icon" href="{{ baseUrl() }}/static/icons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ baseUrl() }}/static/icons/favicon.ico" type="image/x-icon">

    <script src="{{ baseUrl() }}/static/plugins/jquery/jquery-2.1.3.min.js"></script> <!-- for Bootstrap -->

    <!-- Bootstrap -->
    <link href="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ baseUrl() }}/static/plugins/bootstrap-3.3.6/js/bootstrap.min.js"></script>


    <script src="{{ baseUrl() }}/static/plugins/canvasbg/canvas.js"></script>
</head>
<body>
<style type="text/css">
    body {
        overflow: auto;
        height: 100%;
        background: url("{{ baseUrl() }}/static/images/1.jpg") no-repeat top center #2d494d;
    }

    .main {
        overfloat: hidden;
        position: relative;
        min-height: 100%;
    }

    #canvas-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }

    .container {
        margin-top: 10%;
        background-color: white;
        max-width: 500px;
        box-shadow: 0 1px 40px 0 rgba(0, 0, 0, 0.3);
        position: relative;
        padding: 0 !important; /*Bootstrap override*/
    }

    @media screen and (max-width: 480px) {
        .container {
            max-width: 300px;
        }
    }

    .panel-header {
        background: url("{{ baseUrl() }}/static/images/vkk_logo.png") no-repeat center #ffffff;
        padding: 16px;
        height: 100px;
    }

    .panel-content {
        background-color: #eeeeee;
        padding-bottom: 16px;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-signin .checkbox {
        margin-bottom: 10px;
        font-weight: normal;
    }

    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .form-group > label {
        color: #888;
    }
</style>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-77731892-1', 'auto');
    ga('send', 'pageview');

</script>

<div class="main">
    <div id="canvas-wrapper">
        <canvas id="demo-canvas"></canvas>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel-header"></div>
                <div class="panel-content">
                    <form class="form-signin" role="form" method="post">
                        <input type="hidden" name="action" value="login"/>
                        <div class="form-group">
                            <label for="userName">Prisijungimo vardas</label>
                            <input type="text" id="userName" name="userLogin" class="form-control"
                                   placeholder="Įveskite prisijungimo vardą" required/>
                        </div>
                        <div class="form-group">
                            <label for="password">Slaptažodis</label>
                            <input type="password" id="password" name="userPassword" class="form-control"
                                   placeholder="Įveskite slaptažodį" required/>
                        </div>
                        <input type="hidden" id="resolution" name="resolution" value="">
                        <button class="btn btn-md btn-primary" type="submit">Prisijungti</button>
                        <!--<div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember-me"/>Likti prisijungus
                            </label>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('resolution').value = window.screen.width + 'x' + window.screen.height;
    if (document.getElementById('userName').value) {
        document.getElementById('password').focus();
    } else {
        document.getElementById('userName').focus();
    }

    $(document).ready(function () {
        //"use strict";
        CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2,
                y: window.innerHeight / 3.3
            }
        });
    });
</script>
</body>
</html>

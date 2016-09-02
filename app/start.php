<?php

/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.12
 * Time: 20:51
 */
class App
{

    public function init()
    {
        define('APP_DIR', __DIR__);

        date_default_timezone_set('Europe/Vilnius');

        require '../vendor/autoload.php';
        require 'database.php';

        // Instantiate a Slim application.
        $app = new \Slim\Slim([
            'mode' => 'development'
            , 'templates.path' => '../app/views'
            , 'view' => new \Slim\Views\Twig()
            , 'debug' => true
        ]);

        $view = $app->view();
        $view->parserExtensions = array(
            new \Slim\Views\TwigExtension(),
        );

        $app->db = new \Illuminate\Database\Capsule\Manager();

        $app->dbraw = function () {
            return dbRaw();
        };

        //$app->add(new \Slim\Middleware\Minify());

        $app->setName("KAUKARAS");

        $app->session = new \SlimSession\Helper;
        $app->add(new \Slim\Middleware\Session([
            'name' => 'vkk_session',
            'autorefresh' => true,
            'lifetime' => '30 minute'
        ]));

        require 'routes.php';
        require 'aliuscore/index.php';

        return $app;
    }

}

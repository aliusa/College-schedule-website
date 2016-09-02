<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.05
 * Time: 14:14
 */
define('BASE_DIR', __DIR__);

require '../app/start.php';

// Init wrapper.
$init = new App();
// Run the Slim application.
$init->init()->run();

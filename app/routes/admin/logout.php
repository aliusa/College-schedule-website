<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 23:44
 */


$app->group("/admin", function () use ($app) {
    $app->get("/logout", function () use ($app) {
        $app->session->destroy();

        $app->redirect($app->urlFor('admin/login'));
    })->name("admin/logout");
});
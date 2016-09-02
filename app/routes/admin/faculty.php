<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-01-31
 * Time: 14:16
 */
use Kaukaras\Models\Faculty;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/faculty", function () use ($app) {
        $app->get("/", function (int $id = NULL) use ($app) {

            $app->render("Kaukaras.admin/faculty_list.php", [
                'faculties' => Faculty::getAll(),
                'user' => $app->session->get('user'),
                'user_id' => $app->session->get('user_id')
            ]);

        })->setName('admin/faculty');
    });
});
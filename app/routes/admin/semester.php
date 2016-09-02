<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-01-30
 * Time: 19:36
 */

use Kaukaras\Models\Semester;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/semester", function () use ($app) {
        $app->get("(/:id)", function (int $id = NULL) use ($app) {
            if ($id != NULL && Semester::findById($id) != NULL) { // Individual Semester

                // TODO: remove

            } else { // Semester list
                $mSemester = Semester::getSemesters();

                $app->render("Kaukaras.admin/semester_list.php", [
                    'semesters' => $mSemester,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/semester');
    });
});

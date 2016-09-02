<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-01-31
 * Time: 14:16
 */
use Illuminate\Database\Capsule\Manager;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/classroom", function () use ($app) {
        $app->get("/", function (int $id = NULL) use ($app) {

            $mClassrooms = Manager::
            table("classroom as cr")
                ->select(
                    'cr.ClassroomId'
                    , 'cr.Name'
                    , 'cr.Vacancy'
                    , 'fa.Name AS Faculty'
                )
                ->leftJoin('faculty AS fa', 'cr.FacultyId', '=', 'fa.FacultyId')
                ->orderBy('fa.SortOrder')
                ->orderBy('Name')
                ->get();

            $app->render("Kaukaras.admin/classroom_list.php", [
                'classrooms' => $mClassrooms,
                'user' => $app->session->get('user'),
                'user_id' => $app->session->get('user_id')
            ]);

        })->setName('admin/classroom');
    });
});
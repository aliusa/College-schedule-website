<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-15
 * Time: 19:09
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Equipment;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/equipment", function () use ($app) {
        $app->get("(/:id)", function (int $id = NULL) use ($app) {
            if ($id != NULL && Equipment::findById($id) != NULL) {

                // TODO: Indidivual hardware page

            } else {
                /* List of all hardware. */

                $mHardware = Manager::table('equipment')
                    ->select()
                    ->get();

                $app->render("Kaukaras.admin/equipment_list.php", [
                    'hardware' => $mHardware,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/equipment');
    });
});

<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-06-04
 * Time: 08:40
 */

use Kaukaras\Models\Params;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/help", function () use ($app) {
        $app->get("", function () use ($app) {

            $app->render("Kaukaras.admin/help/help.php", [
                'user' => $app->session->get('user'),
                'user_id' => $app->session->get('user_id'),

                'adminEmail' => Params::findById(1)->Title,
                'adminName' => sprintf("%s.%s", substr(Params::findById(1)->Param1, 0, 1), Params::findById(1)->Param2),
                'emailSchoolHelp1' => Params::findById(2),
                'emailSchoolHelp2' => Params::findById(3)
            ]);

        })->name('admin/help');
    });
});

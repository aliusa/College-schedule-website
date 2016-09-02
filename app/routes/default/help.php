<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-06-03
 * Time: 19:41
 */

use Kaukaras\Models\Params;

$app->group("/help", function () use ($app) {

    $app->get("", function () use ($app) {

        cacheLong();


        $app->render("Kaukaras/help.php", [
            'adminEmail' => Params::findById(1)->Title,
            'adminName' => sprintf("%s.%s", substr(Params::findById(1)->Param1, 0, 1), Params::findById(1)->Param2),
            'emailSchoolHelp' => Params::findById(2)->Title
        ]);

    })->name('help');
});
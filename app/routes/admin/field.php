<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-01-31
 * Time: 14:16
 */
use Illuminate\Database\Capsule\Manager;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/field", function () use ($app) {
        $app->get("/", function (int $id = NULL) use ($app) {

            $mFields = Manager::
            table("options_details")
                ->select(
                    'OptionsDetailsId'
                    , 'Name'
                )
                ->orderBy('SortOrder')
                ->where('OptionsId', '=', \Kaukaras\Models\Option::STUDY_FIELD)
                ->get();

            $app->render("Kaukaras.admin/field_list.php", [
                'fields' => $mFields,
                'user' => $app->session->get('user'),
                'user_id' => $app->session->get('user_id')
            ]);

        })->setName('admin/field');
    });
});
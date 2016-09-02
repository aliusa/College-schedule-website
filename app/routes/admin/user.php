<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-14
 * Time: 10:09
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\User;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/user", function () use ($app) {
        $app->get("(/:id)", function (int $id = NULL) use ($app) {

            if ($id != NULL && User::findById($id) != NULL) { // Indicidual User
                /* Selected user. */
                $mUser = User::findById($id);

                $mLoginLog = Manager::
                table("loginlog")
                    ->select(
                        "DateTime"
                        , "IP"
                        , "Browser"
                        , "Platform"
                        , "Resolution"
                    )
                    ->where('UserId', '=', $id)
                    ->orderBy('LoginLogId', 'desc')
                    ->get();

                $app->render("Kaukaras.admin/user.php", [
                    'admin' => $mUser,
                    'logins' => $mLoginLog,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);

            } else { // List of users.

                $mUsers = Manager::
                table("user")
                    ->select(
                        "UserId"
                        , "FirstName"
                        , "LastName"
                        , "Email"
                        , "IsActive"
                    )
                    ->get();

                $app->render("Kaukaras.admin/user_list.php", [
                    'users' => $mUsers,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);

            }
        })->name('admin/user');

        /**
         * In individual User page submitted through edit form
         */
        $app->post("/:id", function (int $id) use ($app) {
            $mUser = User::findById($id);

            /* Get submitted group name. */
            $mFirstName = $app->request->params("firstname");
            $mLastName = $app->request->params("lastname");
            $mEmail = isNotEmptyOr($app->request->params("email"), 0);


            $mUser->FirstName = $mFirstName;
            $mUser->LastName = $mLastName;
            $mUser->Email = $mEmail;

            // Save
            if ($mUser->save()) {
                // On Success reload page.
                $app->redirect($app->urlFor('admin/user', [
                    'id' => $mUser->UserId
                ]));
            }
        });

    });
});
<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 23:44
 */

use Illuminate\Database\Capsule as Capsule;

$app->group("/admin", function () use ($app) {
    $app->get("/login", function () use ($app) {
        $app->render('Kaukaras.admin/login.php');
    })->name("admin/login");

    $app->post("/login", function () use ($app) {

        $mUsername = $app->request->post("userLogin");

        $mAction = $app->request->post("action");
        $mPassword = $app->request->post("userPassword");

        $mResolution = $app->request->post("resolution");

        if ($mAction != "login")
            $app->redirect($app->urlFor('admin/login'));

        $mOS = getOS();
        $mBrowser = getBrowser();

        $stmt = $app->dbraw->prepare("CALL user_login(:username, :password, :ip, :agent, :browser, :platform, :resolution);");
        $stmt->bindParam(':username', $mUsername);
        $stmt->bindParam(':password', $mPassword);
        $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(':agent', $_SERVER['HTTP_USER_AGENT']);
        $stmt->bindParam(':browser', $mOS);
        $stmt->bindParam(':platform', $mBrowser);
        $stmt->bindParam(':resolution', $mResolution);
        $stmt->execute();
        $mUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($mUser) || isset($mUser['msg']))
            $app->redirect($app->urlFor('admin/login'), [
                "error" => "Neteisingi duomenys" // TODO
            ]);

        $mUser = Capsule\Manager::
        table('user')
            ->select("*")
            ->where("user.UserId", '=', $mUser['UserId'])
            ->first();

        $app->session->set('user_id', $mUser->UserId);
        //$app->session->set('username', $mUser['Username']);
        $app->session->set('firstname', $mUser->FirstName);
        $app->session->set('lastname', $mUser->LastName);
        $app->session->set('user', $mUser->FirstName . " " . $mUser->LastName);
        $app->redirect($app->urlFor('admin/index'));
    });
});
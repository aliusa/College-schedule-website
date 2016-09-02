<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 23:04
 */

use Illuminate\Database\Capsule\Manager;

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($app->session->user)) {
            $_SESSION['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Login required');
            $app->redirect($app->urlFor('admin/login'));
        }
    };
};

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->get("/", function () use ($app) {

        $mLectures = Manager::
        table('lecture')
            ->selectRaw('COUNT(LectureId) AS Count')
            ->first();

        $mLogins = Manager::
        table('loginlog AS log')
            ->select(
                "us.FullName"
                , "log.Success"
                , "us.UserId"
                , "log.ip"
            )
            ->selectRaw("DATE_FORMAT(log.DateTime, '%Y-%m-%d %H:%i') AS DateTime")
            ->leftJoin('user AS us', 'log.UserId', '=', 'us.UserId')
            ->orderBy("log.LoginLogId", "desc")
            ->limit(10)
            ->get();

        $mLoggedInToday = Manager::table('loginlog')
            ->where('UserId', $app->session->get('user_id'))
            ->whereRaw('DATE(DateTime) = CURDATE()')
            ->whereRaw("TIME(DateTime) BETWEEN '07:00' AND '10:00'")
            ->get();

        $app->render("Kaukaras.admin/index.php", [
            'lectures' => $mLectures,
            'logins' => $mLogins,
            'loggedToday' => $mLoggedInToday,
            'user' => $app->session->get('user'),
            'user_id' => $app->session->get('user_id')
        ]);
    })->name('admin/index');
});

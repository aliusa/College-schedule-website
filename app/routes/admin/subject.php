<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.20
 * Time: 17:18
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Subject;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/subject", function () use ($app) {

        $app->get("(/:id)", function (int $id = NULL) use ($app) {
            if ($id != NULL && Subject::findById($id) != NULL) { // Individual Subject

                /* Selected subject. */
                $mSubject = Subject::findById($id);

                $app->render("Kaukaras.admin/subject.php", [
                    'subject' => $mSubject,
                    'user' => $app->session->get('user')
                ]);
            } else { // List of subjects.
                $subjects = Manager::
                table("subject")
                    ->select()
                    ->orderBy('Name')
                    ->get();

                $app->render("Kaukaras.admin/subject_list.php", [
                    'subjects' => $subjects,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/subject');

        /**
         * In individual Subject page submitted through edit form
         */
        $app->post("/:id", function (int $id) use ($app) {
            $mSubject = Subject::findById($id);

            /* Get submitted group name. */
            $mSubjectName = $app->request->params("name");

            $mSubjectChangedName = Subject::nameExists($mSubjectName);
            /* Check if name does not already exists and except if it's same group. */
            if ($mSubjectChangedName != null && $mSubject->SubjectId != $mSubjectChangedName->SubjectId) {
                // Name already exists
                /* TODO: show alert */
                $app->redirect($app->urlFor('admin/subject', [
                    'id' => $mSubject->SubjectId
                ]));
            } else {
                /*Change Name.*/
                $mSubject->Name = $mSubjectName;

                /*No value - not cheched. 1 - checked*/
                $mIsActive = $app->request->params("IsntActive");

                $mSubject->IsActive = !isset($mIsActive) OR ("on" === $mIsActive) ? 0 : 1;

                // Save
                if ($mSubject->save()) {
                    // On Success reload page.
                    $app->redirect($app->urlFor('admin/subject', [
                        'id' => $mSubject->SubjectId
                    ]));
                }
            }
        });
    });
});
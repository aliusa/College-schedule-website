<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 23:04
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Option;
use Kaukaras\Models\OptionDetails;
use Kaukaras\Models\Professor;
use Kaukaras\Models\Professor_Semester;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/professor", function () use ($app) {
        $app->get("(/:id)", function (int $id = NULL) use ($app) {
            if ($id != NULL && Professor::findById($id) != NULL) {
                /* Selected professor. */
                $mProfessor = Professor::findById($id);

                $degries = OptionDetails::getDetails(Option::ACADEMIC_DEGREE);

                $mRecurringTask = Manager::
                table("module_cluster as ms")
                    ->select(
                        "mo.ModuleId"
                        , "rt.RecurringTaskId"
                        , 'mo.Credits'
                        , 'ms.IsChosen'
                    )
                    ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS `group`')
                    //->selectRaw("(SELECT COUNT(le.LectureId) FROM lecture AS le WHERE le.RecurringTaskId = rt.RecurringTaskId) AS lecture_count")
                    ->selectRaw("Subject_Name(mo.SubjectId) as Subject")
                    ->selectRaw("Semester_Name(mo.SemesterId) as Semester")
                    ->leftJoin('module AS mo', 'ms.ModuleId', '=', 'mo.ModuleId')
                    ->rightJoin('recurringtask AS rt', 'mo.ModuleId', '=', 'rt.ModuleId')
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
                    //->leftJoin('lecture AS le', 'rt.RecurringTaskId', '=', 'le.RecurringTaskId')// For counting lectures
                    ->orderBy('rt.DateStart', 'desc')
                    ->groupBy('ModuleId')
                    ->where('rt.ProfessorId', '=', $mProfessor->ProfessorId)
                    ->get();

                // Get all semesters, ProfessorId will be 1 if professor that semester has record in DB.
                $mSemesters = Manager::table('semester AS se')
                    ->select(
                        'se.SemesterId'
                        , 'se.Name'
                        , 'ps2.ProfessorId'
                    )
                    ->leftJoin('professor_semester AS ps1', 'ps1.SemesterId', '=', 'se.SemesterId')
                    ->leftJoinWhere('professor_semester AS ps2', 'ps1.ProfessorId', '=', $id)
                    ->groupBy('se.SemesterId')
                    ->orderBy('se.SortOrder')
                    ->get();

                $app->render("Kaukaras.admin/professor.php", [
                    'professor' => $mProfessor,
                    'schedules' => $mRecurringTask,
                    'degries' => $degries,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id'),
                    'semesters' => $mSemesters
                ]);

            } else {
                /* List of all professors. */

                // Adds row number to search record.
                $stmt = $app->dbraw->prepare("SELECT pr.ProfessorId, pr.FirstName, pr.LastName, pr.IsActive, @row := @row + 1 AS row,
                    Option_Name(pr.DegreeId) AS Degree, pr.Email
                        FROM professor AS pr, (SELECT @row := 0) r
                        ORDER BY pr.LastName");
                $stmt->execute();
                $professor = $stmt->fetchAll(PDO::FETCH_CLASS);

                $app->render("Kaukaras.admin/professor_list.php", [
                    'professors' => $professor,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/professor');

        /**
         * In individual Professor page submitted edit form
         */
        $app->post("/:id", function (int $id) use ($app) {
            $mProfessor = Professor::findById($id);

            // Get submitted professor name.
            // Bind values.
            $mProfessor->FirstName = $app->request->params("FirstName");
            $mProfessor->LastName = $app->request->params("LastName");
            $mProfessor->Email = isNotEmptyOr($app->request->params("email"), 0);
            $mProfessor->Notes = isNotEmptyOr($app->request->params("notes"), 0);

            $mDegree = (int)$app->request->params("degree");
            if ($mDegree == 0) {
                $mProfessor->DegreeId = null;
            } else {
                $mProfessor->degree()->associate($mDegree);
            }


            /*No value - not cheched. 1 - checked*/
            $mIsActive = $app->request->params("IsntActive");

            $mProfessor->IsActive = !isset($mIsActive) OR ("on" === $mIsActive) ? 0 : 1;
            $mProfessor->save();


            $mSemesters = &$_POST['semesters'];
            if (isset($mSemesters)) {

                $mCurrentSemesters = $mProfessor->semester()->getResults();
                if (sizeof($mCurrentSemesters) == 0) {
                    foreach ($mSemesters as $val) {
                        // Create new
                        $mProfessorSemester = new Professor_Semester();
                        $mProfessorSemester->semester()->associate((int)$val);
                        $mProfessorSemester->professor()->associate($mProfessor->ProfessorId);
                        $mProfessorSemester->save();
                    }
                } else {

                    $deletableProfessorSemester = Manager::table('professor_semester')
                        ->where('ProfessorId', $mProfessor->ProfessorId)
                        ->whereNotIn('SemesterId', $mSemesters)
                        ->get();
                    foreach ($deletableProfessorSemester as $val) {
                        $mProfessorSemester = Professor_Semester::getByProfessorSemester($mProfessor->ProfessorId, $val->SemesterId);
                        $mProfessorSemester->delete();
                    }

                    foreach ($mSemesters as $val) {
                        // Check if exists
                        $m = Manager::table('professor_semester')
                            ->where('ProfessorId', $mProfessor->ProfessorId)
                            ->where('SemesterId', $val)
                            ->get();
                        if (count($m) == 0) {
                            // Doesn't exist.

                            // Create new
                            $mProfessorSemester = new Professor_Semester();
                            $mProfessorSemester->semester()->associate((int)$val);
                            $mProfessorSemester->professor()->associate($mProfessor->ProfessorId);
                            $mProfessorSemester->save();
                        }
                    }
                }

            } else {
                $deletableProfessorSemester = Manager::table('professor_semester')
                    ->where('ProfessorId', $mProfessor->ProfessorId)
                    ->get();

                foreach ($deletableProfessorSemester as $val) {
                    $mProfessorSemester = Professor_Semester::getByProfessorSemester($mProfessor->ProfessorId, $val->SemesterId);
                    $mProfessorSemester->delete();
                }
            }


            /* On Success redirect */
            $app->redirect($app->urlFor('admin/professor', [
                'id' => $mProfessor->ProfessorId
            ]));

        });
    });

});

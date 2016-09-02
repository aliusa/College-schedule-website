<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 23:04
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Cluster;
use Kaukaras\Models\Faculty;
use Kaukaras\Models\Option;
use Kaukaras\Models\OptionDetails;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/group", function () use ($app) {

        /**
         * In individual Group page submitted edit form
         */
        $app->post("/:id", function (int $id) use ($app) {
            $mCluster = Cluster::findById($id);

            /* Get submitted group name. */
            $mGroupName = $app->request->params("name");

            $mClusterChangedName = Cluster::nameExists($mGroupName);
            /* Check if name does not already exists and except if it's same group. */
            if ($mClusterChangedName != null && $mCluster->ClusterId != $mClusterChangedName->ClusterId) {
                // Name already exists
                /* TODO: show alert */
                $app->redirect($app->urlFor('admin/group', [
                    'id' => $mCluster->ClusterId
                ]));

            } else {
                $mCluster->Name = $mGroupName;
                $mCluster->Email = isNotEmptyOr($app->request->params("email"), 0);

                /*No value - not cheched. 1 - checked*/
                $mIsActive = $app->request->params("IsActive");

                $mCluster->isActive = !isset($mIsActive) OR ("on" === $mIsActive) ? 0 : 1;

                $mCluster->studyForm()->associate((int)$app->request->params("formId"));
                $mCluster->faculty()->associate((int)$app->request->params("facultyId"));
                $mCluster->field()->associate((int)$app->request->params("fieldId"));

                /* Save */
                if ($mCluster->save()) {
                    /* On Success redirect */
                    $app->redirect($app->urlFor('admin/group', [
                        'id' => $mCluster->ClusterId
                    ]));
                }
            }
        });


        $app->get("(/:id(/:year(/:month)))", function (int $id = NULL, $year = null, $month = null) use ($app) {
            if ($id != null && Cluster::findById($id) != NULL) {
                /* Selected group. */
                $mGroup = Cluster::findById($id);

                $field = OptionDetails::getDetails(Option::STUDY_FIELD);
                $form = OptionDetails::getDetails(Option::STUDY_FORM);
                $faculty = Faculty::getAll();

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
                    ->where('sc.ParentId', '=', $mGroup->ClusterId)
                    ->get();

                $app->render("Kaukaras.admin/group.php", [
                    'group' => $mGroup,
                    'fields' => $field,
                    'forms' => $form,
                    'faculties' => $faculty,
                    'schedules' => $mRecurringTask,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id'),
                    'subclusters' => Cluster::getSubclusters($mGroup->ClusterId),
                ]);

            } else {
                /* List of all groups. */
                $group = Manager::
                table("cluster AS cl")
                    ->select(
                        'cl.ClusterId',
                        'cl.Name AS Name',
                        'od1.Name AS StudyForm',
                        'fa.Name AS Faculty',
                        'od3.Name AS Field',
                        'cl.IsActive',
                        'cl.StartYear'
                    )
                    ->leftJoin('options_details AS od1', 'cl.StudyFormId', '=', 'od1.OptionsDetailsId')
                    ->leftJoin('faculty AS fa', 'cl.FacultyId', '=', 'fa.FacultyId')
                    ->leftJoin('options_details AS od3', 'cl.FieldId', '=', 'od3.OptionsDetailsId')
                    ->whereNull('cl.ParentId')
                    ->get();
                $app->render("Kaukaras.admin/group_list.php", [
                    'groups' => $group,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/group');

    });
});

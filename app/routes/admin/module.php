<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.23
 * Time: 16:34
 */
use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Module;

$app->group("/admin", $authenticate($app), function () use ($app) {
    $app->group("/module", function () use ($app) {
        $app->get("(/:id)", function (int $id = NULL) use ($app) {

            if ($id != NULL && Module::findById($id) != NULL) {
                $mModule = Module::findById($id);

                $mRecurringTask = Manager::
                table("recurringtask AS rt")
                    ->select(
                        "rt.RecurringTaskId"
                        , "cl.ClusterId"
                        , "rt.DateStart"
                        , "rt.DateEnd"
                        , "mc.IsChosen"
                    )
                    ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS Name')
                    ->selectRaw("(SELECT COUNT(le.LectureId) FROM lecture AS le WHERE le.RecurringTaskId = rt.RecurringTaskId) AS lecture_count")
                    ->selectRaw("Professor_Name(rt.ProfessorId) AS Professor")
                    ->selectRaw("RecurringTask_Pattern(rt.RecurringTaskId) as msg")
                    ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')
                    ->leftJoin('module_cluster AS mc', 'rt.ModuleClusterId', '=', 'mc.ModuleClusterId')
                    ->leftJoin('cluster AS sc', 'mc.ClusterId', '=', 'sc.ClusterId')
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
                    //->orderBy('se.SortOrder')
                    ->orderBy('rt.DateStart', 'desc')
                    ->where('rt.ModuleId', '=', $mModule->ModuleId)
                    ->get();

                $mSubclusters = getModuleSubclusters($id);

                $app->render("Kaukaras.admin/module.php", [
                    'module' => $mModule,
                    'subject' => $mModule->getSubject()->Name,
                    'semester' => $mModule->getSemester()->Name,
                    'schedules' => $mRecurringTask,
                    'id' => $mModule->ModuleId,
                    'user' => $app->session->get('user'),
                    'user_id' => $app->session->get('user_id'),
                    'subclusters' => $mSubclusters
                ]);

            } else {
                /*gets all records from Module table*/
                $mSchedule = Manager::
                table('module as mo')
                    ->select(
                        'mo.ModuleId',
                        'su.Name as subject_name',
                        'se.Name as semester_name',
                        'se.SortOrder'
                        , 'su.SubjectId'
                        , 'mo.Credits'
                    )
                    ->leftJoin('subject AS su', 'mo.SubjectId', '=', 'su.SubjectId')
                    ->leftJoin('semester AS se', 'mo.SemesterId', '=', 'se.SemesterId')
                    ->orderBy('se.SortOrder', 'asc')
                    ->orderBy('su.Name')
                    ->get();

                //var_dump($mSchedule);
                /*Gets all records from RecurringTask table*/
                $mRecurringTask = Manager::
                table('module_cluster as mc')
                    ->select(
                        'mc.ModuleClusterId'
                        , 'mc.IsChosen'
                        , 'ModuleId' // for grouping
                        , 'cl.ClusterId'
                    )
                    ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS Name')
                    ->leftJoin('cluster AS sc', 'mc.ClusterId', '=', 'sc.ClusterId')
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
                    //->orderBy('rt.DateStart')
                    ->get();

                foreach ($mRecurringTask as $keyR => $valR) {
                    foreach ($mSchedule as $keyS => $valS) {
                        // Check if ModuleId matches
                        if ($valR->ModuleId === $valS->ModuleId) {
                            // Checks if array is initialized OR name already is in array
                            if (!isset($valS->group) || !in_array($valR->Name, $valS->group)) {
                                // Assigns unique group names (with specified subclusters)
                                $valS->group[] = $valR->Name;
                                // For making links to group pages.
                                $valS->groups[] = $valR;
                            }
                        }
                    }
                }

                $app->render("Kaukaras.admin/module_list.php", [
                    'schedules' => $mSchedule
                    , 'user' => $app->session->get('user')
                    , 'user_id' => $app->session->get('user_id')
                ]);
            }
        })->name('admin/module');
    });
});
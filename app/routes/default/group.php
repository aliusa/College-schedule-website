<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 10:02
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Cluster;

$app->group("/group", function () use ($app) {
    $app->get("/:id(/:date)", function ($id, $date = NULL) use ($app) {
        cacheShort();
        if (!is_numeric($id)) {
            $app->redirect($app->urlFor('index'), 400);
        }

        // Selects single Cluster with given ID.
        $group = Cluster::findById($id);

        if ($group === NULL) {
            $app->redirect($app->urlFor('index'), 404);
        }
        $weeks = 1;
        if ($group->StudyFormId == 131) {
            $weeks = 2;
        }

        list($mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday) = getWeekDaysStarting($date, $weeks);
        $weekdays = getWeekDaysFromDate($date, $weeks);


        $mLectures = [];
        foreach ($weekdays as $key => $value) {
            $mOccurence['group'] = Manager::
            table('lecture AS le')
                ->select(
                    'rt.RecurringTaskId' // For With
                    , 'le.ClassroomId'
                    , 'mo.SubjectId'
                    , 'le.Date'
                    , 'le.WeekDay'
                    , 'rt.ProfessorId'
                    , 'ms.ClusterId' // For With
                    , 'rt.OccursEvery'
                    , 'ms.IsChosen'
                    , 'le.IsCanceled'
                    , 'le.Notes'
                    , 'rt.ModuleId' // For With
                    , 'sc.Name AS subcluster_name'
                )
                ->selectRaw('DATE_FORMAT(le.TimeStart, \'%H:%i\') AS TimeStart')
                ->selectRaw('DATE_FORMAT(le.TimeEnd, \'%H:%i\') AS TimeEnd')
                ->selectRaw("Professor_Name(rt.ProfessorId) AS professor")
                ->selectRaw("Subject_Name(mo.SubjectId) AS SubjectName")
                ->selectRaw("Classroom_Name(le.ClassroomId) AS ClassroomName")
                ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')// For Subject
                ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                ->leftJoin('professor AS pr', 'rt.ProfessorId', '=', 'pr.ProfessorId')
                ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                ->where('cl.ClusterId', '=', $id)
                ->where('le.Date', '=', $value['date'])
                ->orderBy('WeekDay')
                ->orderBy('TimeStart')
                ->orderBy('TimeEnd')
                ->orderBy('Name')
                ->groupBy(['rt.ModuleId', 'le.Date', 'TimeStart', 'TimeEnd', 'le.ClassroomId', 'rt.ProfessorId'])
                ->get();

            foreach ($mOccurence['group'] as $key2 => $value2) {
                $mWith = Manager::
                table('lecture AS le')
                    ->select(
                        'le.Notes'
                    )
                    ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                    ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                    ->where('rt.ModuleId', '=', $value2->ModuleId)
                    ->where('le.RecurringTaskId', '!=', $value2->RecurringTaskId)
                    ->where('le.Date', '=', $value2->Date)
                    ->where('ms.ClusterId', '!=', $value2->ClusterId)// subcluster
                    ->where('cl.ClusterId', '!=', $value2->ClusterId)// cluster
                    ->where('le.ClassroomId', '=', $value2->ClassroomId)
                    ->where('le.TimeStart', '=', $value2->TimeStart)
                    ->where('le.TimeEnd', '=', $value2->TimeEnd)
                    ->where('le.IsCanceled', '=', 0)
                    ->orderBy('Name')
                    ->get();

                $value2->with = $mWith;
            }
            $mOccurence['date'] = $value['date'];
            $mOccurence['weedayName'] = getWeekdays()[date('N', strtotime($value['date']))];

            $mLectures[] = $mOccurence;
        }

        $app->render('Kaukaras/group.php', [
            'group' => $group
            , 'weekdays' => $weekdays
            , 'schedule' => $mLectures
            , 'startDate' => $mStartDate
            , 'endDate' => $mEndDate
            , 'lastWeekToday' => $mLastWeekToday
            , 'nextWeekToday' => $mNextWeekToday
        ]);
    })->name('group');
});
<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.15
 * Time: 12:53
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Professor;

$app->group("/professor", function () use ($app) {

    // List of all Professors.
    $app->get("", function () use ($app) {
        cacheShort();
        $professors = Manager::
        table('professor')
            ->select(
                'ProfessorId'
                , 'FirstName'
                , 'LastName'
            )
            ->selectRaw('Option_Name(DegreeId) AS DegreeName')
            ->orderBy("LastName")
            ->orderBy("FirstName")
            ->where('IsActive', '=', 1)
            ->get();

        $app->render("Kaukaras/professor_list.php", [
            'professors' => $professors
        ]);
    })->name('professor_list');

    // Individual Professor.
    $app->get("/:id(/:date)", function ($id, $date = NULL) use ($app) {
        cacheShort();
        if (!is_numeric($id)) {
            $app->redirect($app->urlFor('index'), 400);
        }

        // Selects single Professor with given ID.
        $mProfessor = Professor::findById($id);

        if ($mProfessor === NULL) {
            $app->redirect($app->urlFor('index'), 404);
        }

        list($mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday) = getWeekDaysStarting($date);
        $weekdays = getWeekDaysFromDate($date, 1);

        $mLectures = [];
        foreach ($weekdays as $key => $value) {
            $mOccurence['group'] = Manager::
            table('lecture AS le')
                ->select(
                    'le.RecurringTaskId' // for With
                    , 'mo.ModuleId' // for With
                    , 'le.ClassroomId'
                    , 'cl.ClusterId' //cluster
                    , 'ms.ClusterId AS SubClusterId' //subcluster for With
                    , 'sc.Name AS subcluster_name'
                    , 'le.TimeStart'
                    , 'le.TimeEnd'
                    , 'le.WeekDay'
                    , 'mo.SubjectId'
                    , 'le.Date' // for With
                    , 'rt.OccursEvery'
                    , 'le.Notes'
                    , 'le.IsCanceled'
                    , 'ms.IsChosen'
                    , 'rt.OccursEvery'
                )
                ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                ->selectRaw('Subject_Name(mo.SubjectId) AS SubjectName')
                ->selectRaw('Classroom_Name(le.ClassroomId) AS ClassroomName')
                ->leftJoin('recurringTask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')// For Task, SubCluster
                ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')// For Subject
                ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                ->where('rt.ProfessorId', '=', $id)
                ->where('le.Date', '=', $value['date'])
                ->groupBy(['le.Date', 'le.TimeStart', 'le.TimeEnd', 'le.ClassroomId', 'rt.ModuleId'])
                ->get();

            foreach ($mOccurence['group'] as $key2 => $value2) {
                $mWith = Manager::
                table('lecture AS le')
                    ->select(
                        'cl.ClusterId'
                        , 'sc.Name AS subcluster_name'
                        , 'le.Notes'
                        , 'ms.IsChosen'
                        , 'rt.OccursEvery'
                    )
                    ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                    ->leftJoin('recurringTask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                    ->where('rt.ModuleId', '=', $value2->ModuleId)
                    ->where('le.RecurringTaskId', '!=', $value2->RecurringTaskId)
                    ->where('le.Date', '=', $value2->Date)
                    ->where('ms.ClusterId', '!=', $value2->SubClusterId)//subcluster
                    ->get();

                $value2->with = $mWith;
            }

            $mOccurence['date'] = $value['date'];
            $mOccurence['weedayName'] = getWeekdays()[date('N', strtotime($value['date']))];

            $mLectures[] = $mOccurence;
        }

        $app->render("Kaukaras/professor.php", [
            'professor' => $mProfessor
            , 'weekdays' => $weekdays
            , 'schedule' => $mLectures
            , 'startDate' => $mStartDate
            , 'endDate' => $mEndDate
            , 'lastWeekToday' => $mLastWeekToday
            , 'nextWeekToday' => $mNextWeekToday
        ]);
    })->name('professor');
});
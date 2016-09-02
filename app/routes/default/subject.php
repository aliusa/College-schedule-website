<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.15
 * Time: 12:53
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Subject;

$app->group("/subject", function () use ($app) {

    // List of all Subjects.
    $app->get("", function () use ($app) {

        cacheShort();

        $subjects = Manager::
        table('subject')
            ->select(
                'SubjectId'
                , 'Name'
            )
            ->where('IsActive', '=', 1)
            ->orderBy("Name")
            ->get();

        $app->render("Kaukaras/subject_list.php", [
            'subjects' => $subjects
        ]);
    })->name('subject_list');


    $app->get("/:id(/:date)", function (int $id, $date = NULL) use ($app) {
        cacheLong();
        if (!is_numeric($id)) {
            $app->redirect($app->urlFor('index'), 400);
        }

        // Selects single Subject with given ID.
        $mSubject = Subject::findById($id);

        if ($mSubject === NULL) {
            $app->redirect($app->urlFor('index'), 404);
        }

        list($mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday) = getWeekDaysStarting($date);
        $weekdays = getWeekDaysFromDate($date, 1);

        $mLectures = [];

        foreach ($weekdays as $key => $value) {
            $mOccurence['group'] = Manager::
            table("lecture as le")
                ->select(
                    'le.RecurringTaskId' // for With
                    , 'le.ClassroomId'
                    , 'rt.ProfessorId'
                    , 'le.Date' // for With
                    , 'le.TimeStart'
                    , 'le.TimeEnd'
                    , 'cl.ClusterId'
                    , 'le.Weekday'
                    , 'rt.ModuleId' // for With
                    , 'ms.IsChosen'
                    , 'le.IsCanceled'
                    , 'le.Notes'
                    , 'rt.OccursEvery'
                )
                ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                ->selectRaw("Professor_Name(rt.ProfessorId) AS ProfessorName")
                ->selectRaw("Classroom_Name(le.ClassroomId) AS ClassroomName")
                ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')
                ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                ->leftJoin('professor AS pr', 'rt.ProfessorId', '=', 'pr.ProfessorId')
                ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                ->where('mo.SubjectId', '=', $id)
                ->where('le.Date', '=', $value['date'])
                ->orderBy('le.WeekDay')
                ->orderBy('le.TimeStart')
                ->groupBy('le.Date', 'le.TimeStart', 'le.TimeEnd', 'le.ClassroomId', 'pr.ProfessorId')
                ->get();


            // Searches for Groups having that Subject
            foreach ($mOccurence['group'] as $key2 => $value2) {
                $mWith = Manager::
                table('lecture AS le')
                    ->select(
                        'cl.ClusterId'
                        , 'sc.Name AS subcluster_name'
                        , 'sc.ParentId'
                        , 'ms.IsChosen'
                        , 'le.IsCanceled'
                        , 'le.Notes'
                        , 'rt.OccursEvery'
                    )
                    ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                    ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                    ->where('rt.ModuleId', '=', $value2->ModuleId)
                    ->where('le.RecurringTaskId', '!=', $value2->RecurringTaskId)
                    ->where('le.Date', '=', $value2->Date)
                    ->where('le.ClassroomId', '=', $value2->ClassroomId)
                    ->orderBy('Name')
                    ->orderBy('sc.Name')
                    ->get();

                $value2->with = $mWith;
            }
            $mOccurence['date'] = $value['date'];
            $mOccurence['weedayName'] = getWeekdays()[date('N', strtotime($value['date']))];

            $mLectures[] = $mOccurence;
        }

        //print_r($mSchedule);
        $app->render("Kaukaras/subject.php", [
            'subject' => $mSubject
            , 'weekdays' => $weekdays
            , 'schedule' => $mLectures
            , 'startDate' => $mStartDate
            , 'endDate' => $mEndDate
            , 'lastWeekToday' => $mLastWeekToday
            , 'nextWeekToday' => $mNextWeekToday
        ]);
    })->name('subject');
});
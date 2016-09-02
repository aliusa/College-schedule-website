<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.15
 * Time: 12:53
 */

use Illuminate\Database\Capsule\Manager;

$app->group("/day", function () use ($app) {

    // List of all Subjects.
    $app->get("(/:date)", function ($date = NULL) use ($app) {
        cacheShort();
        $weeks = 1;
        list($mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday) = getWeekDaysStarting($date, $weeks);
        $weekdays = getWeekDaysFromDate($date, 1);

        $mLectures = [];
        foreach ($weekdays as $key => $value) {
            $mOccurence['group'] = Manager::
            table('lecture as le')
                ->select(
                    'le.TimeStart'
                    , 'le.TimeEnd'
                    , 'le.ClassroomId'
                    , 'mo.SubjectId'
                    , 'rt.ProfessorId'
                    , 'le.Weekday'
                    , 'cl.FacultyId'
                    , 'le.IsCanceled'
                    , 'le.Notes'
                    , 'rt.OccursEvery'
                )
                ->selectRaw('Subject_Name(mo.SubjectId) AS SubjectName')
                ->selectRaw('Professor_Name(rt.ProfessorId) AS ProfessorName')
                ->selectRaw('Classroom_Name(le.ClassroomId) AS ClassroomName')
                ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')
                ->leftJoin('classroom AS cl', 'le.ClassroomId', '=', 'cl.ClassroomId')
                ->where('le.Date', '=', $value['date'])
                ->orderBy('le.TimeStart')
                ->orderBy('le.TimeEnd')
                ->groupBy('le.ClassroomId', 'mo.SubjectId')
                ->get();

            foreach ($mOccurence['group'] as $key2 => $value2) {
                $mGroups = Manager::
                table('lecture as le')
                    ->select(
                        'rt.ProfessorId'
                        , 'ms.IsChosen'
                        , 'cl.ClusterId'
                        , 'le.IsCanceled'
                        , 'le.Notes'
                        , 'rt.OccursEvery'
                    )
                    ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                    ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                    ->where('le.Date', '=', $value['date'])
                    ->where('le.TimeStart', '=', $value2->TimeStart)
                    ->where('le.TimeEnd', '=', $value2->TimeEnd)
                    ->where('le.ClassroomId', '=', $value2->ClassroomId)
                    ->where('rt.ProfessorId', '=', $value2->ProfessorId)
                    ->orderBy('le.TimeStart')
                    ->orderBy('le.TimeEnd')
                    ->get();

                $value2->with = $mGroups;
            }
            $mOccurence['date'] = $value['date'];
            $mOccurence['weedayName'] = getWeekdays()[date('N', strtotime($value['date']))];

            $mLectures[] = $mOccurence;
        }

        $app->render("Kaukaras/day_list.php", [
            'schedule' => $mLectures
            , 'weekdays' => $weekdays
            , 'startDate' => $mStartDate
            , 'endDate' => $mEndDate
            , 'lastWeekToday' => $mLastWeekToday
            , 'nextWeekToday' => $mNextWeekToday
        ]);
    })->name('day_list');
});
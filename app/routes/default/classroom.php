<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.15
 * Time: 12:53
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Classroom;
use Kaukaras\Models\Faculty;

$app->group("/classroom", function () use ($app) {

    // List of all Classrooms.
    $app->get("", function () use ($app) {

        cacheLong();

        $mFaculties = Manager::
        table('faculty')
            ->select(
                'FacultyId'
                , 'Name'
            )
            ->orderBy('SortOrder')
            ->get();

        $mClassrooms = Manager::
        table('classroom')
            ->select(
                'ClassroomId'
                , 'Name'
                , 'FacultyId'
            )
            //->where('FacultyId', '=', $val->FacultyId)
            //->orderBy("FacultyId")
            ->orderBy("Name")
            ->get();


        $arr = [];
        // Get unique Fields of Clusters.
        foreach ($mClassrooms as $ke => $va) {
            if (!in_array($va->FacultyId, $arr))
                $arr[] = $va->FacultyId;
        }


        foreach ($arr as &$valA) {
            foreach ($mFaculties as $keyF => $valF) {
                if ($valA === $valF->FacultyId) {
                    $valA = $valF;
                    $valA->classrooms = null;
                    // Assings Classrooms to it's Faculty
                    foreach ($mClassrooms as $keyC => $valC) {
                        if ($valA->FacultyId === $valC->FacultyId) {
                            $valA->classrooms[] = $valC;
                        }
                    }
                }
            }

            // Assings Classrooms which doesn't belong to any Faculty
            if ($valA == NULL) {
                foreach ($mClassrooms as $keyC => $valC) {
                    if ($valC->FacultyId == NULL) {
                        $valA->classrooms[] = $valC;
                    }
                }
            }
        }
        $mFaculties = $arr;

        $app->render("Kaukaras/classroom_list.php", [
            'faculties' => $mFaculties
        ]);
    })->name('classroom_list');


    $app->get("/:id(/:date)", function ($id, $date = NULL) use ($app) {
        cacheShort();
        if (!is_numeric($id)) {
            $app->redirect($app->urlFor('index'), 400);
        }

        // Selects single Classroom with given ID.
        $mClassroom = Classroom::findById($id);

        $mFacultyName = null;
        if ($mClassroom->FacultyId != null) {
            $mFacultyName = Faculty::findById($mClassroom->FacultyId)->Name;
        }

        // Checks if Classroom is valid.
        if ($mClassroom === NULL) {
            $app->redirect($app->urlFor('index'), 404); // TODO: redirect to 404 page
        }

        list($mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday) = getWeekDaysStarting($date);
        $weekdays = getWeekDaysFromDate($date, 1);

        $mLectures = [];
        foreach ($weekdays as $key => $value) {
            $mOccurence['group'] = Manager::
            table("lecture as le")
                ->select(
                    'le.ClassroomId'
                    , 'rt.ProfessorId'
                    , 'le.Date' // For With
                    , 'le.TimeStart'
                    , 'le.TimeEnd'
                    , 'mo.SubjectId'
                    , 'le.Weekday'
                    , 'rt.ModuleId' // For With
                    , 'le.RecurringTaskId' // For With
                    //, 'ms.ClusterId' // For With
                    , 'rt.OccursEvery'
                )
                ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                ->selectRaw("Professor_Name(rt.ProfessorId) AS ProfessorName")
                ->selectRaw("Subject_Name(mo.SubjectId) AS SubjectName")
                ->selectRaw("Classroom_Name(le.ClassroomId) AS ClassroomName")
                ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')// For Module->Subject
                ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')// For Subject
                ->leftJoin('professor AS pr', 'rt.ProfessorId', '=', 'pr.ProfessorId')
                ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                ->where('le.ClassroomId', '=', $id)
                ->where('le.Date', '=', $value['date'])
                ->orderBy('le.Date')
                ->orderBy('le.TimeStart')
                ->groupBy('le.Date', 'le.TimeStart', 'le.TimeEnd', 'le.ClassroomId', 'rt.ProfessorId', 'rt.ModuleId')
                ->get();

            // Searches for Groups having that Subject
            foreach ($mOccurence['group'] as $key2 => $value2) {
                $mWith = Manager::
                table('lecture AS le')
                    ->select(
                        'cl.ClusterId' //subcluster
                        , 'ms.IsChosen'
                        , 'le.Notes'
                        , 'le.IsCanceled'
                        , 'rt.OccursEvery'
                    )
                    ->selectRaw("IF(sc.Name != \"0\", CONCAT(cl.Name, ' (', sc.Name, ' pogr.)'), cl.Name) AS Name")
                    ->leftJoin('recurringtask AS rt', 'le.RecurringTaskId', '=', 'rt.RecurringTaskId')// For Module
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')// For Subcluster
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')// For cluster name
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')// For subcluster name
                    ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')// For SubjectId
                    ->where('rt.ModuleId', '=', $value2->ModuleId)
                    ->where('le.Date', '=', $value2->Date)
                    ->where('le.ClassroomId', '=', $value2->ClassroomId)
                    ->orderBy('le.Date')
                    //->orderBy('ClusterName')
                    //->orderBy('SubclusterName')
                    ->get();

                $value2->with = $mWith;
            }

            $mOccurence['date'] = $value['date'];
            $mOccurence['weedayName'] = getWeekdays()[date('N', strtotime($value['date']))];

            $mLectures[] = $mOccurence;
        }

        // print_r($mSchedule);
        $app->render("Kaukaras/classroom.php", [
            'classroom' => $mClassroom
            , 'weekdays' => $weekdays
            , 'schedule' => $mLectures
            , 'startDate' => $mStartDate
            , 'endDate' => $mEndDate
            , 'lastWeekToday' => $mLastWeekToday
            , 'nextWeekToday' => $mNextWeekToday
            , 'faculty' => $mFacultyName
        ]);
    })->name('classroom');
});
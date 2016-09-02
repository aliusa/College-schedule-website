<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.31
 * Time: 10:26
 */

use Illuminate\Database\Capsule\Manager;
use Kaukaras\Models\Classroom;
use Kaukaras\Models\Classroom_Equipment;
use Kaukaras\Models\Cluster;
use Kaukaras\Models\Equipment;
use Kaukaras\Models\Faculty;
use Kaukaras\Models\Lecture;
use Kaukaras\Models\Module;
use Kaukaras\Models\ModuleCluster;
use Kaukaras\Models\Option;
use Kaukaras\Models\OptionDetails;
use Kaukaras\Models\Professor;
use Kaukaras\Models\Professor_Semester;
use Kaukaras\Models\RecurringTask;
use Kaukaras\Models\Semester;
use Kaukaras\Models\Subject;

/**
 * Gets all SubClusters.
 * @return mixed
 */
function getSubClusters()
{
    return
        Manager::
        table("cluster AS sc")
            ->select(
                'sc.ClusterId AS id'
                , 'cl.FacultyId AS faculty_id'
                , 'fa.Name AS faculty_name'
            )
            ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS Name')
            ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
            ->leftJoin('faculty AS fa', 'cl.FacultyId', '=', 'fa.FacultyId')
            ->where('cl.IsActive', '=', 1)// All active groups.
            ->orderBy('faculty_name', 'DESC')
            ->orderBy('Name')
            ->get();
}

function getProfessors()
{
    return Manager::
    table('professor')
        ->select(
            'ProfessorId AS id'
        )
        ->selectRaw("CONCAT(LastName, ' ', SUBSTRING(FirstName FROM 1 FOR 1), '.') AS Name")
        ->orderBy('Name')
        ->where('IsActive', '=', 1)
        ->get();
}

function getClassrooms()
{
    return Manager::
    table('classroom AS cl')
        ->select(
            'cl.ClassroomId AS id'
            , 'cl.Name'
            , 'cl.FacultyId AS faculty_id'
            , 'fa.Name AS faculty_name'
        )
        ->leftJoin('faculty AS fa', 'cl.FacultyId', '=', 'fa.FacultyId')
        ->orderBy('cl.FacultyId')
        ->orderBy('cl.Name')
        ->get();
}

function getSemesters()
{
    return Manager::
    table('semester')
        ->select(
            'SemesterId'
            , 'Name'
        )
        ->orderBy('SortOrder')
        ->get();
}

function getSubjects()
{
    return Manager::
    table('subject')
        ->select(
            'SubjectId'
            , 'Name'
        )
        ->orderBy('Name')
        ->where('IsActive', '=', 1)
        ->get();
}

function getMostLectureHavingFK(string $table, string $groupBy, int $recurringTaskId)
{
    return
        Manager::
        table($table)
            ->select(
                $groupBy . " AS id"
            )
            ->selectRaw("COUNT(?) AS nums", [$groupBy])
            ->orderBy("nums", "desc")
            ->groupBy($groupBy)
            ->limit(1)
            ->where('RecurringTaskId', '=', $recurringTaskId)
            ->get();
}

function getModuleSubclusters(int $moduleId)
{
    return $mSubclusters = Manager::table('module_cluster as ms')
        ->select(
            'ms.ModuleClusterId'
            , 'sc.ClusterId'
            , 'ms.IsChosen'
        )
        ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS Name')
        ->leftJoin('cluster as sc', 'ms.ClusterId', '=', 'sc.ClusterId')
        ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
        ->where('ModuleId', '=', $moduleId)
        ->get();
}

$app->group("/ajax", function () use ($app) {
    $app->group("/group", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { /*Show form.*/
                $field = OptionDetails::getDetails(Option::STUDY_FIELD);
                $form = OptionDetails::getDetails(Option::STUDY_FORM);
                $faculty = Faculty::getAll();

                $app->render("Kaukaras.admin/ajax/group/add.php", [
                    'fields' => $field,
                    'forms' => $form,
                    'faculties' => $faculty,
                    'user' => $app->session->get('user')
                ]);

            } else { // Parse form dialog data.
                $mPost = $_POST;
                $mAction = $mPost['action'];
                $mName = trim($mPost['name']);
                $mEmail = trim($mPost['email']);
                $mFieldId = $mPost['fieldId'];
                $mFormId = $mPost['formId'];
                $mFacultyId = $mPost['facultyId'];
                $mSubcluster = &$mPost['subclusters'];
                $mStartYear = $mPost['startYear'];

                if (null != Cluster::nameExists($mName)) {
                    jsonResponse(false, "Grupė tokiu pavadinimu jau egzistuoja");
                } else {
                    $mCluster = new Cluster();

                    $mCluster->Name = $mName;
                    $mCluster->Email = isNotEmptyOr($mEmail, 0);

                    $mCluster->isActive = 1;
                    $mCluster->isArchived = 0;
                    $mCluster->field()->associate((int)$mFieldId);
                    $mCluster->studyForm()->associate((int)$mFormId);
                    $mCluster->faculty()->associate((int)$mFacultyId);
                    $mCluster->StartYear = $mStartYear;

                    if ($mCluster->save()) {

                        // Create main clusters subcluster
                        $mSubCluster = new Cluster();
                        $mSubCluster->Name = 0;
                        $mSubCluster->cluster()->associate(Cluster::getLast()->ClusterId);
                        $mSubCluster->save();

                        $subclusterCount = sizeof($mSubcluster);
                        if ($subclusterCount > 0) {
                            // Iterate over all subcluster input entries
                            foreach ($mSubcluster as $val) {
                                // Check if subcluster name was empty
                                $empty = empty($val);

                                if (!$empty) {
                                    // Create new Subcluster
                                    $mSubCluster = new Cluster();
                                    $mSubCluster->Name = $val;
                                    $mSubCluster->cluster()->associate(Cluster::getLast()->ClusterId);
                                    $mSubCluster->save();
                                }
                            }
                        }

                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Nepavyko išsaugoti");
                    }
                }

            }
        })->name('ajax/group/add');
    });

    $app->group("/professor", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $mDegrees = OptionDetails::getDetails(Option::ACADEMIC_DEGREE);

                // Get all semesters, ProfessorId will be 1 if professor that semester has record in DB.
                $mSemesters = Manager::table('semester AS se')
                    ->select(
                        'se.SemesterId'
                        , 'se.Name'
                    )
                    ->groupBy('se.SemesterId')
                    ->orderBy('se.SortOrder')
                    ->get();

                $app->render("Kaukaras.admin/ajax/professor/add.php", [
                    'degries' => $mDegrees
                    , 'semesters' => $mSemesters
                ]);

            } else { // Parse form dialog data.

                /*$myfile = fopen("testfile.txt", "a") or die("Unable to open file!");
                $txt = $_POST;
                file_put_contents('testfile.txt', print_r($txt, true));
                fclose($myfile);*/

                $mPost = $_POST;

                $mProfessor = new Professor();
                $mProfessor->FirstName = trim($mPost['FirstName']);
                $mProfessor->LastName = trim($mPost['LastName']);
                $mProfessor->Email = isNotEmptyOr($mPost['email'], 0);
                $mProfessor->Notes = isNotEmptyOr($mPost['notes'], 0);

                $mDegree = &$mPost['degree'];
                if ($mDegree == NULL OR $mDegree == 0) {
                    $mProfessor->DegreeId = null;
                } else {
                    $mProfessor->degree()->associate((int)$mDegree);
                }

                if ($mProfessor->save()) {

                    // Save selected semesters
                    $mSemesters = &$_POST['semesters'];
                    if (isset($mSemesters)) {
                        foreach ($mSemesters as $val) {
                            // Create new
                            $mProfessorSemester = new Professor_Semester();
                            $mProfessorSemester->semester()->associate((int)$val);
                            $mProfessorSemester->professor()->associate($mProfessor->ProfessorId);
                            $mProfessorSemester->save();
                        }
                    }

                    // TODO: check if each Professor_Semester was saved.
                    echo json_encode(["success" => true]);
                } else {
                    jsonResponse(false, "Nepavyko išsaugoti");
                }
            }

        })->name('ajax/professor/add');

        // Used for displaying professor list in schedule list when module list item clicked.
        $app->get("/read/:id", function (int $id = NULL) use ($app) {
            if ($id == NULL) {
                jsonResponse(true);
            } else {
                $mLectures = Manager::
                table("professor AS pr")
                    ->select(
                        "pr.ProfessorId AS id"
                    )
                    ->selectRaw('Professor_Name(pr.ProfessorId) AS Name')
                    ->leftJoin('professor_semester AS ps', 'pr.ProfessorId', '=', 'ps.ProfessorId')
                    ->leftJoin('semester AS se', 'ps.SemesterId', '=', 'se.SemesterId')
                    ->leftJoin('module AS mo', 'se.SemesterId', '=', 'mo.SemesterId')
                    ->where('mo.ModuleId', '=', $id)
                    ->get();

                echo json_encode($mLectures);
            }

        })->name('ajax/professor/read');
    });

    $app->group("/subject", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/subject/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mPost = $_POST;
                $mName = $mPost['name'];
                $mIsActive = isset($_POST['isnt_active']) ? 0 : 1;

                if (null != Subject::nameExists($mName)) {
                    jsonResponse(false, "Dalykas tokiu pavadinimu jau egzistuoja");
                } else {
                    $mSubject = new Subject();
                    $mSubject->Name = trim($app->request->params("name"));
                    $mSubject->IsActive = $mIsActive;
                    if ($mSubject->save()) {
                        echo json_encode(["success" => true]);
                    } else {
                        echo json_encode([
                            "success" => false,
                            "msg" => "Nepavyko išsaugoti"
                        ]);
                    }
                }
            }

        })->name('ajax/subject/add');
    });

    $app->group("/schedule", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $mClassrooms = getClassrooms();

                $mModules = Manager::
                table('module')
                    ->select(
                        'module.ModuleId'
                        , 'module.Credits'
                    )
                    ->selectRaw("Semester_Name(module.SemesterId) AS Semester")
                    ->selectRaw("Subject_Name(module.SubjectId) AS Subject")
                    ->get();

                $app->render("Kaukaras.admin/ajax/recurringtask/add.php", [
                    'classrooms' => $mClassrooms,
                    'modules' => $mModules,
                ]);

            } else { // Parse form dialog data.

                // Boolean to indicate if success already returned.
                $mOutputed = false;

                if (!isset($_POST['group']))
                    jsonResponse(false, "Nepasirinkta grupė (pogrupis)");
                else
                    $mGroupsId = $_POST['group'];

                if (!isset($_POST['module']))
                    jsonResponse(false, "Nepasirinktas modulis");
                else
                    $mModuleId = (int)$_POST['module'];

                if (!isset($_POST['classroom']))
                    jsonResponse(false, "Nepasirinkta auditorija");
                else
                    $mClassroomId = (int)$_POST['classroom'];

                if (!isset($_POST['professor']))
                    jsonResponse(false, "Nepasirinktas dėstytojas");
                else
                    $mProfessorId = (int)$_POST['professor'];

                // boolean ('true' or null) value given from modals.js to confirm classroom overlap.
                $mIgoneClassroomOverlap = &$_POST['ignoreClassroomOverlap'];
                $mIgoneSubclusterOverlap = &$_POST['ignoreSubclusterOverlap'];

                /**
                 * 1 - One time
                 * 2 - Daily
                 * 3 - Weekly
                 * 4 - Monthly
                 * 5 - Specific dates
                 * 6 - Yearly
                 */
                $mOccurs = (int)$_POST['occurs']; // 1 <= x <= 6
                $mOccursEvery = (int)$_POST['occurs_every']; // >=1
                $mTimeStart = $_POST['time_start'];
                $mWeekdaysId = &$_POST['weekdays'];

                $tempTimeEnd = (int)$_POST['time_end'][0]; // Selected item from selection.
                if ($tempTimeEnd === 0 || $tempTimeEnd === 1) {
                    // Initialize duration.
                    $mDuration = null;
                    if ($tempTimeEnd === 0) { // Default 01:30 was selected.
                        $mDuration = $_POST['time_end_default'];
                    } else if ($tempTimeEnd === 1) { // Ends after specific time was selected.
                        $mDuration = $_POST['time_end_id'][0];
                    }
                    $mTimeEnd = date('H:i', strtotime('+' . substr($mDuration, 0, 2) . ' hours', strtotime($mTimeStart)));
                    $mTimeEnd = date('H:i', strtotime('+' . substr($mDuration, 3, 5) . ' minutes', strtotime($mTimeEnd)));
                } else if ($tempTimeEnd === 2) { // Ends on specific time was selected.
                    $mTimeEnd = $_POST['time_end_id'][1];
                }

                $mDateStart = $_POST['date_start'];


                /**
                 * @var array array of suitable dates $mDates
                 */
                $mDates = [];
                if ($mOccurs === 1) { // Once
                    $mDates[] = $_POST['occurs_once'];
                } else if ($mOccurs === 3) { // Weekly
                    $mEndsAfterXItem = $mDateEnd = $mEndsAfterXWeeks = null;
                    if ((int)$_POST['date_end'][0] === 0) { // Ends on date.
                        $mDateEnd = $_POST['date_end_id_0'];
                    } else if ((int)$_POST['date_end'][0] === 1) { // End after x items.
                        $mEndsAfterXItem = (int)$_POST['date_end_id_1'];
                    } else if ((int)$_POST['date_end'][0] === 2) { // End after x weeks.
                        $mEndsAfterXWeeks = $_POST['date_end_id_2'];
                    }


                    // Checks and assigns selected week days.
                    // Fill array with 0's of lenght of 7 starting at index 1.
                    $mIsDay = array_fill(1, 7, 0);
                    foreach ($mWeekdaysId as $key => $value) {
                        $mIsDay[(int)$value] = 1;
                    }

                } else if ($mOccurs === 5) { // On specified dates
                    // Parses each date from popup calendar's dates string
                    $mDates = explode(", ", $_POST['occurs_specific_dates']);
                    sort($mDates);
                }


                if ($mOccurs === 3 && $mEndsAfterXItem != null) { // 3 - weekly and ends after x lectures.
                    $date = $mDateStart;
                    $i = 1;
                    while ($i <= $mEndsAfterXItem) {
                        if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                            $mDates[] = $date;
                            $i++;
                        }
                        // Adds 1 day to iterating days.
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                        // If repeats every >= 2 weeks, then skips to days to correct week.
                        if ($mOccursEvery >= 2) {
                            $intWeekday = getWeekdayOfDate($date);
                            while ($intWeekday <= 7) { // Loops current week till Sunday.
                                if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                                    $mDates[] = $date;
                                    $i++;
                                }
                                // Adds 1 day to become Monday.
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                $intWeekday++;
                            }
                            //  Skips x weeks. -1 because today is Monday.
                            $intSkipWeeks = $mOccursEvery - 1;
                            $date = date("Y-m-d", strtotime("+$intSkipWeeks week", strtotime($date)));
                        }
                    }
                } else if ($mOccurs === 3 && $mDateEnd != null) { // 3 - weekly and ends on selected date
                    $date = $mDateStart;
                    // Iterates over interval of dates.
                    while (date('Y-m-d', strtotime($date)) <= date('Y-m-d', strtotime($mDateEnd))) {
                        // Searches if date is equal to selected weekday.
                        if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                            $mDates[] = $date;
                        }

                        // Goes to next date, or Monday.
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                        // If repeats every >= 2 weeks, then skips to days to correct week.
                        if ($mOccursEvery >= 2) {
                            $intWeekday = getWeekdayOfDate($date);
                            while ($intWeekday <= 7) { // Loops current week till Sunday.
                                if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                                    $mDates[] = $date;
                                }
                                // Adds 1 day to become Monday.
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                $intWeekday++;
                            }
                            // Skips x weeks. -1 because today is Monday.
                            $intSkipWeeks = $mOccursEvery - 1;
                            $date = date("Y-m-d", strtotime("+$intSkipWeeks week", strtotime($date)));
                        }
                    }
                } else if ($mOccurs === 3 && $mEndsAfterXWeeks != null) { // 3 - weekly and ends after x weeks
                    $date = $mDateStart;
                    $i = 1;
                    while ($i <= $mEndsAfterXWeeks) {
                        if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                            $mDates[] = $date;
                            $i++;
                        }
                        // Adds 1 day to iterating days.
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                        // If repeats every >= 2 weeks, then skips to days to correct week.
                        if ($mOccursEvery >= 2) {
                            $intWeekday = getWeekdayOfDate($date);
                            while ($intWeekday <= 7) { // Loops current week till Sunday.
                                if (in_array(getWeekdayOfDate($date), $mWeekdaysId)) {
                                    $mDates[] = $date;
                                    $i++;
                                }
                                // Adds 1 day to become Monday.
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                $intWeekday++;
                            }
                            //  Skips x weeks. -1 because today is Monday.
                            $intSkipWeeks = $mOccursEvery - 1;
                            $date = date("Y-m-d", strtotime("+$intSkipWeeks week", strtotime($date)));
                        }
                    }
                }
                $mDateEnd = end($mDates); // Last Lecture date.


                //region Classroom availability
                // Check if classroom is available
                $mOccurence = Manager::table("lecture as le")
                    ->select(
                        "le.Date"
                    )
                    ->selectRaw("DATE_FORMAT(le.TimeStart, '%H:%i') AS TimeStart")
                    ->selectRaw("DATE_FORMAT(le.TimeEnd, '%H:%i') AS TimeEnd")
                    ->whereIn('le.Date', $mDates)
                    ->where('le.ClassroomId', '=', $mClassroomId)
                    ->whereRaw("((? <= le.TimeStart && ? >= le.TimeStart)", [$mTimeStart, $mTimeEnd])
                    ->whereRaw("(? <= le.TimeEnd && ? >= le.TimeEnd))", [$mTimeStart, $mTimeEnd], 'OR')
                    ->get();

                // Check if anything was found on selected date
                if (sizeof($mOccurence) != 0 && !$mIgoneClassroomOverlap) {
                    $string = '';
                    foreach ($mOccurence as $key => $value) {
                        // Each query might have >= 2 results, so we need to run inner cycler.
                        $string .= sprintf("%s (%s-%s)<br/>",
                            $value->Date,
                            $value->TimeStart,
                            $value->TimeEnd
                        );
                    }
                    $string = substr($string, 0, -5);

                    // Put every date to string.
                    $dates = "Auditorija nustatytu laiku (<b>$mTimeStart - $mTimeEnd</b>) užimta, pasirinkite kitą laiką, 
arba tęskite nepaisant to.<br/><b>Užimtos dienos:</b><br/>" . $string;

                    // Export dates to show to user in modal.
                    jsonResponse(false, $dates, 601);
                    // Code used in `modals.js` to show confirm modal to allow overlap.
                }
                // else allow overlap
                //endregion


                //region Subcluster availability
                // Check if classroom is available
                $mOccurence = Manager::table("lecture AS le")
                    ->select(
                        "le.Date"
                    )
                    ->selectRaw("DATE_FORMAT(le.TimeStart, '%H:%i') AS TimeStart")
                    ->selectRaw("DATE_FORMAT(le.TimeEnd, '%H:%i') AS TimeEnd")
                    ->leftJoin("recurringtask as rt", "le.RecurringTaskId", '=', 'rt.RecurringTaskId')
                    ->leftJoin("module_cluster as ms", "rt.ModuleClusterId", '=', 'ms.ModuleClusterId')
                    ->whereIn('le.Date', $mDates)
                    ->whereIn('ms.ClusterId', $mGroupsId)
                    ->whereRaw("((? <= le.TimeStart && ? >= le.TimeStart)", [$mTimeStart, $mTimeEnd])
                    ->whereRaw("(? <= le.TimeEnd && ? >= le.TimeEnd))", [$mTimeStart, $mTimeEnd], 'OR')
                    ->get();

                // Check if anything was found on selected date
                if (sizeof($mOccurence) != 0 && !$mIgoneSubclusterOverlap) {
                    $string = '';
                    foreach ($mOccurence as $key => $value) {
                        // Each query might have >= 2 results, so we need to run inner cycler.
                        $string .= sprintf("%s (%s-%s)<br/>",
                            $value->Date,
                            $value->TimeStart,
                            $value->TimeEnd
                        );
                    }
                    $string = substr($string, 0, -5);

                    // Put every date to string.
                    $dates = "Grupė (pogrupis) nustatytu laiku (<b>$mTimeStart - $mTimeEnd</b>) užimta, pasirinkite kitą laiką, 
arba tęskite nepaisant to.<br/><b>Užimtos dienos:</b><br/>" . $string;

                    // Export dates to show to user in modal.
                    jsonResponse(false, $dates, 602);
                    // Code used in `modals.js` to show confirm modal to allow overlap.
                }
                // else allow overlap
                //endregion

                // Iterates over all groups.
                foreach ($mGroupsId as $keyG => $valueG) {
                    $mRecurringTask = new RecurringTask();
                    $mRecurringTask->module()->associate($mModuleId);
                    $mRecurringTask->module_cluster()->associate((int)$valueG);
                    $mRecurringTask->professor()->associate($mProfessorId);
                    if (count($mDates) === 1)
                        $mRecurringTask->IsRecurring = 0;
                    else
                        $mRecurringTask->IsRecurring = 1;
                    $mRecurringTask->DateStart = $mDates[0];
                    $mRecurringTask->TimeStart = $mTimeStart;
                    $mRecurringTask->TimeEnd = $mTimeEnd;
                    if ($mOccurs === 3) { // Weekly on specified weekdays
                        $mRecurringTask->IsMonday = $mIsDay[1];
                        $mRecurringTask->IsTuesday = $mIsDay[2];
                        $mRecurringTask->IsWednesday = $mIsDay[3];
                        $mRecurringTask->IsThursday = $mIsDay[4];
                        $mRecurringTask->IsFriday = $mIsDay[5];
                        $mRecurringTask->IsSaturday = $mIsDay[6];
                        $mRecurringTask->IsSunday = $mIsDay[7];
                    } else if ($mOccurs === 5) { /*FIXME:WTF to do? specified days*/
                        $mRecurringTask->IsMonday = 0;
                        $mRecurringTask->IsTuesday = 0;
                        $mRecurringTask->IsWednesday = 0;
                        $mRecurringTask->IsThursday = 0;
                        $mRecurringTask->IsFriday = 0;
                        $mRecurringTask->IsSaturday = 0;
                        $mRecurringTask->IsSunday = 0;
                    }
                    $mRecurringTask->Occurs = $mOccurs;
                    /**
                     * 0 - is not recurrent
                     * 1 - Every time (day/week/month)
                     * 2 - Every 2nd week/month
                     */
                    if ($mOccurs === 3) // Every week
                        $mRecurringTask->OccursEvery = $mOccursEvery;
                    else if ($mOccurs === 5) // On Selected days
                        $mRecurringTask->OccursEvery = 0;

                    $mRecurringTask->DateEnd = $mDateEnd; // Last lecture date.

                    if ($mRecurringTask->save()) {
                        // Creates Lectures.
                        foreach ($mDates as $keyD => $valueD) {
                            $mRecurringTask = RecurringTask::getLast();
                            $mLecture = new Lecture();
                            $mLecture->recurringTask()->associate($mRecurringTask->RecurringTaskId);
                            $mLecture->classroom()->associate($mClassroomId);
                            $mLecture->Date = $valueD;
                            $mLecture->TimeStart = $mTimeStart;
                            $mLecture->TimeEnd = $mTimeEnd;
                            $mLecture->WeekDay = getWeekdayOfDate($valueD);
                            //$mLecture->Notes = null; // TODO
                            $mLecture->save();
                        }
                        if (!$mOutputed) {
                            echo json_encode(["success" => true]);
                            $mOutputed = true;
                        }
                    }
                }
            }
        })->name('ajax/recurringtask/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Paskaita tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                $mSemesterId = (int)$_POST['semester'];
                $mSubjectId = (int)$_POST['subject'];
                $mProfessorId = (int)$_POST['professor'];
                // 0 comes as checked.
                $mIsChosen = isset($_POST['is_chosen']) ? 1 : 0;

                $mRecurringTask = RecurringTask::findById($id);
                $mModule = Module::findById($mRecurringTask->ModuleId);

                $mNeedNewRecurringTask = false;

                if ($mRecurringTask->getSemester()->SemesterId != $mSemesterId) {
                    $mNeedNewRecurringTask = true;
                } elseif ($mRecurringTask->getSubjet()->SubjectId != $mSubjectId) {
                    $mNeedNewRecurringTask = true;
                }

                if ($mNeedNewRecurringTask) {

                    // Find if there's already Module with that Semester, Subject and Credit count.
                    $mIsModule = Manager::
                    table('module')
                        ->where('SemesterId', '=', $mSemesterId)
                        ->where('SubjectId', '=', $mSubjectId)
                        ->where('Credits', '=', $mModule->Credits)
                        ->first();

                    if ($mIsModule == NULL) {
                        // Create new Module with selected parameters
                        $mModuleNew = new Module();
                        $mModuleNew->semester()->associate($mSemesterId);
                        $mModuleNew->subject()->associate($mSubjectId);
                        $mModuleNew->Credits = $mModule->Credits;
                        // Save newly created Module
                        if ($mModuleNew->save()) {

                            // Fetch created module to associate it with RecurringTask
                            $mRecurringTask->module()->associate($mModuleNew->ModuleId);

                            if ($mRecurringTask->save()) {

                                $mRecurringModule = RecurringTask::findByModuleId($mModule->ModuleId);
                                if ($mRecurringModule == NULL) {
                                    // Delete old Module if it has no RecurringTasks
                                    $mModule->delete();
                                }

                                jsonResponse(true);
                            } else {
                                jsonResponse(false, 'Klaida priskiriant naują Modulį!');
                            }

                        } else {
                            jsonResponse(false, 'Klaida išsaugant Modulį!');
                        }
                    } else {
                        $mRecurringTask->module()->associate($mIsModule);
                    }

                } else {

                    if ($mRecurringTask->ProfessorId != $mProfessorId) {
                        $mRecurringTask->professor()->associate($mProfessorId);
                    }

                    $mModuleSubcluster = ModuleCluster::findById($mRecurringTask->ModuleClusterId);
                    if ($mModuleSubcluster->IsChosen != $mIsChosen) {
                        $mModuleSubcluster->IsChosen = $mIsChosen;
                    }

                    if ($mRecurringTask->save() && $mModuleSubcluster->save()) {
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, 'Klaida išsaugant esamą tvarkaraščio kortelę arba "Pasirenkamasis"!');
                    }

                }

            } else {
                // Opens form to edit individual lecture.

                $mRecurringTask = Manager::
                table('recurringtask as rt')
                    ->select(
                        'rt.RecurringTaskId'
                        , 'mo.SemesterId'
                        , 'mo.SubjectId'
                        , 'mc.IsChosen'
                        , 'rt.ProfessorId'
                    )
                    ->leftJoin('module as mo', 'rt.ModuleId', '=', 'mo.ModuleId')
                    ->leftJoin('module_cluster AS mc', 'mo.ModuleId', '=', 'mc.ModuleId')
                    ->where('rt.RecurringTaskId', '=', $id)
                    ->first();

                $mSemesters = getSemesters();
                $mSubjects = getSubjects();
                $mProfessors = getProfessors();

                $app->render("Kaukaras.admin/ajax/recurringtask/edit.php", [
                    'schedule' => $mRecurringTask,
                    'semesters' => $mSemesters,
                    'subjects' => $mSubjects,
                    'professors' => $mProfessors,
                ]);
            }
        })->name('ajax/recurringtask/edit');

        // Used for displaying lecture list in schedule list when schedule list item clicked.
        $app->get("/read/:id/(:group)", function (int $id = NULL, int $group = 0) use ($app) {
            if ($id == NULL) {
                jsonResponse(true);
            } else {

                // Gets all lectures to be displayed in table
                $mLectures = Manager::
                table("recurringtask as rt")
                    ->select(
                        "rt.RecurringTaskId AS id"
                        , 'rt.DateStart'
                        , 'rt.DateEnd'
                        , 'ms.IsChosen'
                        , 'rt.IsMonday'
                        , 'rt.IsTuesday'
                        , 'rt.IsWednesday'
                        , 'rt.IsThursday'
                        , 'rt.IsFriday'
                        , 'rt.IsSaturday'
                        , 'rt.IsSunday'
                    )
                    ->selectRaw("(SELECT COUNT(le.LectureId) FROM lecture AS le WHERE le.RecurringTaskId = rt.RecurringTaskId) AS lecture_count")
                    ->selectRaw("WEEKDAY(rt.DateStart) AS DateStartWeekday")
                    ->selectRaw("WEEKDAY(rt.DateEnd) AS DateEndWeekday")
                    ->selectRaw("RecurringTask_Pattern(rt.RecurringTaskId) as msg")
                    ->selectRaw("Professor_Name(rt.ProfessorId) as Professor")
                    ->leftJoin('lecture AS le', 'rt.RecurringTaskId', '=', 'le.RecurringTaskId')// For counting lectures
                    ->leftJoin('module AS mo', 'rt.ModuleId', '=', 'mo.ModuleId')
                    ->leftJoin('module_cluster AS ms', 'rt.ModuleClusterId', '=', 'ms.ModuleClusterId')
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')
                    ->where('rt.ModuleId', '=', $id)
                    ->orderBy('rt.DateStart')
                    ->groupBy('rt.RecurringTaskId')
                    ->whereRaw("IF(? != 0, ?, sc.ClusterId) = sc.ClusterId", [$group, $group])
                    ->get();

                echo json_encode([$mLectures]);
            }

        })->name('ajax/recurringtask/read');
    });

    $app->group("/lecture", function () use ($app) {

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Paskaita tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                $mClassroom = (int)$_POST['classroom'];
                $mDate = $_POST['date'];
                $mTimeStart = substr($_POST['time_start'], 0, 5);
                $mTimeEnd = substr($_POST['time_end'], 0, 5);
                $mComment = $_POST['comment'];

                $mLecture = Lecture::findById($id);
                $mLectureNew = new Lecture();
                $mLectureNew->recurringTask()->associate($mLecture->RecurringTaskId);
                $mLectureNew->classroom()->associate($mLecture->ClassroomId);
                $mLectureNew->Date = $mLecture->Date;
                $mLectureNew->TimeStart = $mLecture->TimeStart;
                $mLectureNew->TimeEnd = $mLecture->TimeEnd;
                $mLectureNew->Duration = $mLecture->Duration;
                $mLectureNew->WeekDay = $mLecture->WeekDay;

                $mNeedNewLecture = false;

                $msg = [];
                if ($mLecture->ClassroomId != $mClassroom) {
                    $mOld = Classroom::findById($mLecture->ClassroomId)->Name;
                    $mNew = Classroom::findById($mClassroom)->Name;
                    $msg[] = sprintf("Pakeista auditorija, iš %s į %s.", $mOld, $mNew);
                    $mLecture->classroom()->associate($mClassroom);
                }
                if ($mLecture->Date != $mDate) {
                    $mOld = $mLecture->Date;
                    $mNew = $mDate;
                    $msg[] = sprintf("Pakeista diena, iš %s į %s.", $mOld, $mNew);
                    $mLectureNew->Date = $mDate;
                    $mLectureNew->WeekDay = getWeekdayOfDate($mDate);
                    $mNeedNewLecture = true;
                }
                if (substr($mLecture->TimeStart, 0, 5) != $mTimeStart) {
                    $mOld = substr($mLecture->TimeStart, 0, 5);
                    $mNew = $mTimeStart;
                    $msg[] = sprintf("Pakeistas pražios laikas, iš %s į %s.", $mOld, $mNew);
                    $mLecture->TimeStart = $mTimeStart;
                }
                if (substr($mLecture->TimeEnd, 0, 5) != $mTimeEnd) {
                    $mOld = substr($mLecture->TimeEnd, 0, 5);
                    $mNew = $mTimeEnd;
                    $msg[] = sprintf("Pakeistas pabaigos laikas, iš %s į %s.", $mOld, $mNew);
                    $mLecture->TimeEnd = $mTimeEnd;
                }

                if (isset($_POST['canceled'])) { // 0 comes as checked.
                    $mLecture->IsCanceled = 1;
                } else {
                    $mLecture->IsCanceled = 0;
                }

                // 0 - checked, 1 - not checked. 1 - canceled, 0 - not canceled.
                if ($mNeedNewLecture)
                    $mLecture->IsCanceled = 1;

                if ($mLecture->Notes != $mComment) {
                    $mLecture->Notes = $mComment;
                }

                if ($mLecture->Notes != null)
                    array_unshift($msg, " ");
                $mLecture->Notes .= " " . implode(" ", $msg);;

                $mLecture->Notes = trim($mLecture->Notes);

                if (!$mLecture->save()) {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Klaida išsaugant paskaitą!"
                    ]);
                }

                if ($mNeedNewLecture) {
                    $mLectureNew->Duration = getDuration($mLectureNew->TimeStart, $mLectureNew->TimeEnd);
                    $mLectureNew->save();
                }

                echo json_encode([
                    "success" => true,
                    "msg" => "Sėkmingai išsaugota."
                ]);

            } else {
                // Opens form to edit individual lecture.


                $mLecture = Lecture::findById($id);

                $mClassrooms = getClassrooms();

                $app->render("Kaukaras.admin/ajax/lecture/edit.php", [
                    'lecture' => $mLecture,
                    'classrooms' => $mClassrooms,
                ]);
            }
        })->name('ajax/lecture/edit');

        $app->post("/add(/:id)", function (int $id = NULL) use ($app) {
            if (count($_POST) === 0) { // Show form.

                $mClassrooms = getClassrooms();

                // Calculates which Classroom has most Lectures in specified RecurringTask.
                $mClassroomHavingMostLectures = getMostLectureHavingFK("lecture", "ClassroomId", $id)[0];

                $mTimeStartRecurringTask = RecurringTask::findById($id)->TimeStart;
                $mTimeEndRecurringTask = RecurringTask::findById($id)->TimeEnd;

                $app->render("Kaukaras.admin/ajax/lecture/add.php", [
                    'classrooms' => $mClassrooms,
                    'classroomWithLectures' => $mClassroomHavingMostLectures,
                    'time_start' => $mTimeStartRecurringTask,
                    'time_end' => $mTimeEndRecurringTask
                ]);
            } else {

                if (!isset($_POST['professor']))
                    jsonResponse(false, "Nepasirinktas dėstytojas");
                else
                    $mProfessorId = (int)$_POST['professor']; // TODO: repricated

                if (!isset($_POST['classroom']))
                    jsonResponse(false, "Nepasirinkta auditorija");
                else
                    $mClassroomId = (int)$_POST['classroom'];

                $mLecture = new Lecture();
                $mLecture->recurringTask()->associate($id);
                $mLecture->classroom()->associate($mClassroomId);
                $mLecture->professor()->associate($mProfessorId); // TODO: remove!!! Depricated
                $mLecture->Date = $_POST['date'];
                $mLecture->TimeStart = $_POST['time_start'];
                $mLecture->TimeEnd = $_POST['time_end'];
                $mLecture->Duration = getDuration($_POST['time_start'], $_POST['time_end']);
                $mLecture->WeekDay = getWeekdayOfDate($_POST['date']);
                // Insert Comment if it's length >= 1
                $mLecture->Notes = isNotEmptyOr(trim($_POST['comment']), 0);
                if ($mLecture->save()) {
                    /**
                     * It's parent RecurringTask and updates
                     * DateStart, DateEnd if Lecture if out of bounds.
                     */

                    $mRecurringTask = RecurringTask::findById($id);
                    // Lecture date is smaller
                    if (compareDates($_POST['date'], $mRecurringTask->DateStart) === -1) {
                        $mRecurringTask->DateStart = $_POST['date'];
                        $mRecurringTask->save();
                    }
                    // Lecture date is bigger
                    if (compareDates($_POST['date'], $mRecurringTask->DateEnd) === 1) {
                        $mRecurringTask->DateEnd = $_POST['date'];
                        $mRecurringTask->save();
                    }

                    jsonResponse(true);
                }
            }
        })->name('ajax/lecture/add');

        // View lecture list by clicking in schedule list `Peržiūrėti paskaitas`.
        $app->post("/view(/:id)", function (int $id = NULL) use ($app) {

            if ($id != NULL) {

                $mLectures = Manager::
                table('lecture AS le')
                    ->select(
                        'le.LectureId'
                        , 'le.ClassroomId'
                        , 'le.Date'
                        , 'le.Notes'
                        , 'le.RecurringTaskId'
                    )
                    ->selectRaw("Time_standard(le.TimeStart) AS TimeStart")
                    ->selectRaw("Time_standard(le.TimeEnd) AS TimeEnd")
                    ->selectRaw("Classroom_Name(le.ClassroomId) AS Classroom")
                    ->where('le.RecurringTaskId', '=', $id)
                    ->get();

                $app->render("Kaukaras.admin/ajax/lecture/list.php", [
                    'lectures' => $mLectures
                ]);

            } else {

                $mLecture = Manager::
                table('lecture AS le')
                    ->select(
                        'le.ClassroomId'
                        , 'le.ProfessorId'
                        , 'le.Date'
                        , 'sc.ClusterId'
                        , 'ta.SubjectId'
                    )
                    ->leftJoin('recurringtask AS rt', 'rt.RecurringTaskId', '=', 'le.RecurringTaskId')
                    ->leftJoin('module AS ta', 'ta.TaskId', '=', 'rt.TaskId')
                    ->leftJoin('subcluster AS sc', 'sc.SubClusterId', '=', 'rt.SubClusterId')
                    ->where('le.LectureId', '=', $id)
                    ->first();

                $app->render("Kaukaras.admin/ajax/lecture/view.php", [
                    'lecture' => $mLecture,
                ]);
            }

        })->name('ajax/lecture/view');

        // Used for displaying lecture list in schedule list when schedule list item clicked.
        $app->get("/read/:id", function (int $id = NULL) use ($app) {
            if ($id == NULL) {
                jsonResponse(true);
            } else {
                // Gets all lectures to be displayed in table
                $mLectures = Manager::
                table("lecture AS le")
                    ->select(
                        "le.LectureId AS id"
                        , "le.Date AS date"
                        , "le.WeekDay AS day"
                        , "cl.Name AS classroom"
                        , "le.Notes AS notes"
                        , "le.ProfessorId as professorid"
                        , 'le.IsCanceled AS canceled'
                        , 'le.RecurringTaskId AS recurringtaskid'
                    )
                    ->selectRaw("DATE_FORMAT(le.TimeStart, '%H:%i') AS start")
                    ->selectRaw("DATE_FORMAT(le.TimeEnd, '%H:%i') AS end")
                    ->selectRaw("CONCAT(pr.LastName, ' ', SUBSTRING(pr.FirstName FROM 1 FOR 1), '.') AS professor")
                    ->leftJoin('professor AS pr', 'le.ProfessorId', '=', 'pr.ProfessorId')
                    ->leftJoin('classroom AS cl', 'le.ClassroomId', '=', 'cl.ClassroomId')
                    ->where('le.RecurringTaskId', '=', $id)
                    ->orderBy('le.Date')
                    ->orderBy('le.TimeStart')
                    ->orderBy('le.TimeEnd')
                    ->get();

                echo json_encode([$mLectures]);
            }

        })->name('ajax/lecture/read');

        // Used in main admin page to show in calendar heatmap
        $app->post("/count", function (int $id = NULL) use ($app) {
            // Returns array of dates of lecture which has lectures, with number of lectures in each date between two dates.
            $mLecturesByDate = Manager::
            table('lecture')
                ->selectRaw("COUNT(lecture.LectureId) AS value")
                ->selectRaw("UNIX_TIMESTAMP(lecture.Date) AS date")
                ->selectRaw("Year(lecture.Date) AS Year")
                ->groupBy("lecture.Date")
                ->orderBy("lecture.Date")
                ->whereBetween("lecture.Date", [date("Y-m-d", strtotime(currentDateTime() . " -60 day")),
                    date("Y-m-d", strtotime(currentDateTime() . " + 90 days"))])
                ->where("lecture.IsCanceled", '=', 0)
                ->get();

            echo json_encode($mLecturesByDate);

        })->name('ajax/lecture/count');
    });

    $app->group("/semester", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/semester/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mPost = $_POST;
                $mName = $mPost['name'];

                // Checks if there's already Semester with given name.
                if (null != Semester::nameExists($mName)) {
                    jsonResponse(false, "Semestras tokiu pavadinimu jau egzistuoja");
                } else {
                    $mSemester = new Semester();
                    $mSemester->Name = trim($app->request->params("name")); // Remove whitespace from start and end.
                    if ($mSemester->save()) { // Save Semester
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Nepavyko išsaugoti");
                    }
                }
            }

        })->name('ajax/semester/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {

            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Semestras tokiu ID neegzistuoja!"
                ]);
            }

            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                $mSemester = Semester::findById($id);

                // Get submitted group name.
                $mSemesterName = $app->request->params("name");

                $mSemesterChangedName = Semester::nameExists($mSemesterName);

                // Check if name does not already exists and except if it's same group.
                if ($mSemesterChangedName != null && $mSemester->SemesterId != $mSemesterChangedName->SemesterId) {

                    // Name already exists

                    jsonResponse(false);

                } else {

                    // Change Name.
                    $mSemester->Name = $mSemesterName;

                    // Save
                    if ($mSemester->save()) {

                        jsonResponse(true);
                    }
                }

            } else {
                // Opens form to edit individual semester.

                $mSemester = Semester::findById($id);

                $app->render("Kaukaras.admin/ajax/semester/edit.php", [
                    'semester' => $mSemester
                ]);
            }
        })->name('ajax/semester/edit');
    });

    $app->group("/classroom", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $faculty = Faculty::getAll();
                $mHardware = Manager::table('equipment')
                    ->select()
                    ->where('Type', '=', \Kaukaras\Models\Equipment::TYPE_HARDWARE)
                    ->get();
                $mSoftware = Manager::table('equipment')
                    ->select()
                    ->where('Type', '=', \Kaukaras\Models\Equipment::TYPE_SOFTWARE)
                    ->get();

                $app->render("Kaukaras.admin/ajax/classroom/add.php", [
                    'faculties' => $faculty,
                    'hardware' => $mHardware,
                    'software' => $mSoftware,
                ]);

            } else { // Parse form dialog data.

                $mName = $_POST['name'];
                $mVacancy = strlen($_POST['vacancy']) !== 0 ? (int)$_POST['vacancy'] : null;
                $mFacultyId = &$_POST['facultyId'];

                if ($_POST['facultyId'] == null) {
                    jsonResponse(false, "Nepasirinktas skyrius!");
                } else {
                    if (Classroom::classroomExists($mName, (int)$mFacultyId) != NULL) {
                        jsonResponse(false, "Tokia auditorija tokiam skyriui jau egzistuoja");
                    }
                }

                $mClassroom = new Classroom();
                $mClassroom->Name = trim($app->request->params("name"));

                if ($mFacultyId == null || $mFacultyId == 0) {
                    $mClassroom->FacultyId = null;
                } else {
                    $mClassroom->faculty()->associate((int)$mFacultyId);
                }

                $mClassroom->Vacancy = $mVacancy;

                if ($mClassroom->save()) {

                    $mLastClassroomId = Manager::table('classroom')
                        ->select('ClassroomId')
                        ->orderBy('ClassroomId', 'desc')
                        ->limit(1)
                        ->get()[0];

                    $mHardwareList = &$_POST['hardware'];
                    if ($mHardwareList != null && is_array($mHardwareList)) {
                        foreach ($mHardwareList as $key) {
                            $mClassroomEquipment = new Classroom_Equipment();
                            $mClassroomEquipment->classroom()->associate($mLastClassroomId->ClassroomId);
                            $mClassroomEquipment->equipment()->associate((int)$key);
                            $mClassroomEquipment->save();
                        }
                    }
                    $mSoftwareList = &$_POST['software'];
                    if ($mSoftwareList != null && is_array($mSoftwareList)) {
                        foreach ($mSoftwareList as $key) {
                            $mClassroomEquipment = new Classroom_Equipment();
                            $mClassroomEquipment->classroom()->associate($mLastClassroomId->ClassroomId);
                            $mClassroomEquipment->equipment()->associate((int)$key);
                            $mClassroomEquipment->save();
                        }
                    }

                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Nepavyko išsaugoti. Kreiptis į administratorių");
                }

            }

        })->name('ajax/classroom/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Auditorija tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                // Get submitted group name.
                $mClassroomName = $app->request->params("name");
                $mVacancy = strlen($_POST['vacancy']) !== 0 ? (int)$_POST['vacancy'] : null;
                $mFacultyId = &$_POST['facultyId'];

                $mClassroom = Classroom::findById($id);

                if ($mFacultyId == null || $mFacultyId == 0) {
                    $mClassroom->FacultyId = null;
                } else {
                    $mClassroom->faculty()->associate((int)$mFacultyId);
                }

                if ($mClassroom->Name != $mClassroomName) {
                    $mClassroom->Name = $mClassroomName;
                }
                $mClassroom->Vacancy = $mVacancy;

                // TODO: save new hardware/software, delete unselected.

                $mHardware = &$_POST['hardware'];
                $mSoftware = &$_POST['software'];

                // Nothing was passend through Hardware dropdown
                if (empty($mHardware)) {

                    // Delete all software with matching Classroom
                    Manager::table('classroom_equipment')
                        ->leftJoin('equipment as eq', 'classroom_equipment.EquipmentId', '=', 'eq.EquipmentId')
                        ->where('ClassroomId', '=', $id)
                        ->where('eq.Type', '=', Equipment::TYPE_HARDWARE)
                        ->delete();

                } else {
                    // Array of all assigned Hardware to Classroom
                    $mClassroomEquipmentHardware = $mClassroom->equipment()->where('equipment.Type', Equipment::TYPE_HARDWARE)->get()->toArray();

                    if (empty($mClassroomEquipmentHardware)) {

                        // Insert new items from form

                        foreach ($mHardware as $val) {
                            $mClassroomEquipment = new Classroom_Equipment();
                            $mClassroomEquipment->classroom()->associate($id);
                            $mClassroomEquipment->equipment()->associate((int)$val);
                            $mClassroomEquipment->save();
                        }

                    } else {

                        // Check each

                        // Delete Classroom_Equipment if it's not in Hardware array
                        foreach ($mClassroomEquipmentHardware as $val) {

                            if (!in_array((int)$val['EquipmentId'], $mHardware)) {
                                Manager::table('classroom_equipment')
                                    ->select()
                                    ->where('ClassroomId', '=', $id)
                                    ->where('EquipmentId', '=', $val['EquipmentId'])
                                    ->delete();
                            }

                        }

                        // Insert new Hardware
                        foreach ($mHardware as $val1) {
                            $mFoundOld = false;
                            foreach ($mClassroomEquipmentHardware as $key2 => $val2) {
                                if ((int)$val1 === $val2['EquipmentId']) {
                                    $mFoundOld = true;
                                }
                            }
                            if (!$mFoundOld) {
                                $mClassroomEquipment = new Classroom_Equipment();
                                $mClassroomEquipment->classroom()->associate($id);
                                $mClassroomEquipment->equipment()->associate((int)$val1);
                                $mClassroomEquipment->save();
                            }
                        }
                    }
                }

                // Nothing was passend through Software dropdown
                if (empty($mSoftware)) {

                    // Delete all software with matching Classroom
                    Manager::table('classroom_equipment')
                        ->leftJoin('equipment as eq', 'classroom_equipment.EquipmentId', '=', 'eq.EquipmentId')
                        ->where('ClassroomId', '=', $id)
                        ->where('eq.Type', '=', Equipment::TYPE_SOFTWARE)
                        ->delete();
                } else {

                    // Array of all assigned Hardware to Classroom
                    $mClassroomEquipmentHardware = $mClassroom->equipment()->where('equipment.Type', Equipment::TYPE_SOFTWARE)->get()->toArray();

                    if (empty($mClassroomEquipmentHardware)) {

                        // Insert new items from form

                        foreach ($mSoftware as $val) {
                            $mClassroomEquipment = new Classroom_Equipment();
                            $mClassroomEquipment->classroom()->associate($id);
                            $mClassroomEquipment->equipment()->associate((int)$val);
                            $mClassroomEquipment->save();
                        }

                    } else {

                        // Check each

                        // Delete Classroom_Equipment if it's not in Hardware array
                        foreach ($mClassroomEquipmentHardware as $val) {

                            if (!in_array((int)$val['EquipmentId'], $mSoftware)) {
                                Manager::table('classroom_equipment')
                                    ->where('ClassroomId', '=', $id)
                                    ->where('EquipmentId', '=', $val['EquipmentId'])
                                    ->delete();
                            }

                        }

                        // Insert new Hardware
                        foreach ($mSoftware as $val1) {
                            $mFoundOld = false;
                            foreach ($mClassroomEquipmentHardware as $key2 => $val2) {
                                if ((int)$val1 === $val2['EquipmentId']) {
                                    $mFoundOld = true;
                                }
                            }
                            if (!$mFoundOld) {
                                $mClassroomEquipment = new Classroom_Equipment();
                                $mClassroomEquipment->classroom()->associate($id);
                                $mClassroomEquipment->equipment()->associate((int)$val1);
                                $mClassroomEquipment->save();
                            }
                        }
                    }
                }

                if ($mClassroom->save()) {
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Klaida išsaugant paskaitą!");
                }

            } else {
                // Opens form to edit individual lecture.

                $mClassroom = Classroom::findById($id);
                $faculty = Faculty::getAll();
                $mClassroomEquipmentHardware = $mClassroom->equipment()->where('equipment.Type', Equipment::TYPE_HARDWARE)->get()->toArray();
                $mClassroomEquipmentSoftware = $mClassroom->equipment()->where('equipment.Type', Equipment::TYPE_SOFTWARE)->get()->toArray();

                $mHardware = Manager::table('equipment')
                    ->select()
                    ->where('Type', '=', Equipment::TYPE_HARDWARE)
                    ->get();
                $mSoftware = Manager::table('equipment')
                    ->select()
                    ->where('Type', '=', Equipment::TYPE_SOFTWARE)
                    ->get();

                $app->render("Kaukaras.admin/ajax/classroom/edit.php", [
                    'classroom' => $mClassroom,
                    'faculties' => $faculty,
                    'classroom_equipment_hardware' => $mClassroomEquipmentHardware,
                    'classroom_equipment_software' => $mClassroomEquipmentSoftware,
                    'hardware' => $mHardware,
                    'software' => $mSoftware,
                ]);
            }
        })->name('ajax/classroom/edit');
    });

    $app->group("/field", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/field/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mPost = $_POST;
                $mName = $mPost['name'];

                if (null != OptionDetails::nameExists($mName, Option::STUDY_FIELD)) {
                    jsonResponse(false, "Programa tokiu pavadinimu jau egzistuoja");
                } else {
                    $mField = new OptionDetails();

                    $mLastDetail = OptionDetails::lastId(Option::STUDY_FIELD);
                    if ($mLastDetail == null) {
                        $mField->OptionsDetailsId = Option::findById(Option::STUDY_FIELD)->IntervalStart;
                    } else {
                        $mField->OptionsDetailsId = OptionDetails::lastId(Option::STUDY_FIELD) + 1;
                    }

                    $mField->OptionsId = Option::STUDY_FIELD;
                    $mField->Name = trim($app->request->params("name"));
                    if ($mField->save()) {
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Nepavyko išsaugoti");
                    }
                }
            }

        })->name('ajax/field/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Auditorija tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                // Get submitted field name.
                $mFieldName = $app->request->params("name");

                $mField = OptionDetails::findById($id);
                $mField->Name = $mFieldName;

                if ($mField->save()) {
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Klaida išsaugant studijų programą!");
                }

            } else {
                // Opens form to edit individual lecture.

                $mField = OptionDetails::findById($id);

                $app->render("Kaukaras.admin/ajax/field/edit.php", [
                    'field' => $mField,
                ]);
            }
        })->name('ajax/field/edit');
    });

    $app->group("/faculty", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/field/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mName = $_POST['name'];

                if (null != Faculty::nameExists($mName)) {
                    jsonResponse(false, "Skyrius tokiu pavadinimu jau egzistuoja");
                } else {
                    $mFaculty = new Faculty();

                    $mFaculty->Name = trim($app->request->params("name"));
                    if ($mFaculty->save()) {
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Nepavyko išsaugoti");
                    }
                }
            }

        })->name('ajax/faculty/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Fakultetas tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                // Get submitted field name.
                $mFacultyName = trim($app->request->params("name"));

                $mFaculty = Faculty::findById($id);
                $mFaculty->Name = $mFacultyName;

                if ($mFaculty->save()) {
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Klaida išsaugant studijų programą!");
                }

            } else {
                // Opens form to edit individual lecture.

                $mFaculty = Faculty::findById($id);

                $app->render("Kaukaras.admin/ajax/faculty/edit.php", [
                    'faculty' => $mFaculty,
                ]);
            }
        })->name('ajax/faculty/edit');
    });

    $app->group("/equipment", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/equipment/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mName = $_POST['name'];

                if (null != Equipment::nameExists($mName)) {
                    jsonResponse(false, "Įranga tokiu pavadinimu jau egzistuoja");
                } else {
                    $mHardware = new Equipment();
                    $mHardware->Name = trim($app->request->params("name"));
                    $mHardware->Type = (int)$app->request->params("equipment");
                    if ($mHardware->save()) {
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Nepavyko išsaugoti");
                    }
                }
            }

        })->name('ajax/equipment/add');
    });

    $app->group("/module", function () use ($app) {
        $app->post("/add", function () use ($app) {

            if (count($_POST) === 0) { // Show form.

                $mSemesters = getSemesters();
                $mSubjects = getSubjects();
                $mSubClusters = getSubClusters();

                $app->render("Kaukaras.admin/ajax/module/add.php", [
                    'semesters' => $mSemesters,
                    'subjects' => $mSubjects,
                    'subclusters' => $mSubClusters
                ]);

            } else { // Parse form dialog data.


                $mSemesterId = (int)$app->request->params("semester");
                $mSubjectId = (int)$app->request->params("subject");
                $mCredits = (int)$app->request->params("credits");
                $mSubclusters = $app->request->params("subclusters");

                if ($mSemesterId === 0) {
                    jsonResponse(false, "Pasirinkite semestrą");
                } else if ($mSubjectId === 0) {
                    jsonResponse(false, "Pasirinkite dalyką");
                } else if ($mSubclusters === NULL) {
                    jsonResponse(false, "Pasirinkite bent vieną pogrupį");
                }

                $mModule = new Module();
                $mModule->semester()->associate($mSemesterId);
                $mModule->subject()->associate($mSubjectId);
                $mModule->Credits = $mCredits;
                $mModule->save();

                foreach ($mSubclusters as $val) {
                    $mModuleSubcluster = new ModuleCluster();
                    $mModuleSubcluster->module()->associate($mModule->getId());
                    $mModuleSubcluster->subCluster()->associate((int)$val);

                    $mSubClusterId = (int)$val;

                    $mIsChosen = &$_POST['is_chosen' . "_" . $mSubClusterId];
                    $mIsChosen = $mIsChosen == NULL ? 0 : 1;

                    $mModuleSubcluster->IsChosen = $mIsChosen;
                    $mModuleSubcluster->save();
                }

                if ($mModule->save()) {
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Nepavyko išsaugoti");
                }
            }

        })->name('ajax/module/add');

        // Used for displaying lecture list in schedule list when schedule list item clicked.
        $app->get("/read/:id", function (int $id = NULL) use ($app) {
            if ($id == NULL) {
                jsonResponse(true);
            } else {
                $mLectures = Manager::
                table("module_cluster AS ms")
                    ->select(
                        "ms.ModuleClusterId AS id"
                    )
                    ->selectRaw('IF(sc.Name != "0", CONCAT(cl.Name, \' (\', sc.Name, \' pogr.)\'), cl.Name) AS Name')
                    ->leftJoin('cluster AS sc', 'ms.ClusterId', '=', 'sc.ClusterId')
                    ->leftJoin('cluster AS cl', 'sc.ParentId', '=', 'cl.ClusterId')
                    ->where('ms.ModuleId', '=', $id)
                    ->get();

                echo json_encode($mLectures);
            }

        })->name('ajax/module/read');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Modulis tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                $semester = $_POST['semester'];
                $subject = $_POST['subject'];
                $credits = $_POST['credits'];

                $mModule = Module::findById($id);

                if ($mModule->SemesterId != $semester) {
                    $mModule->semester()->associate($semester);
                }
                if ($mModule->SubjectId != $subject) {
                    $mModule->subject()->associate($subject);
                }
                if ($mModule->Credits != $credits) {
                    $mModule->Credits = $credits;
                }
                $mModule->save();

                $subclusters = $_POST['is_chosen_hidden'];
                foreach ($subclusters as $val) {
                    // Get ModuleSubcluster record of that subcluster
                    $mModuleSubcluster = ModuleCluster::findByModuleAndCluster($id, $val);

                    // Check if checkbox selected and passed as 'on'
                    if (isset($_POST['is_chosen_' . $val])) {
                        // Check if IsChosen === 0
                        if (!$mModuleSubcluster->IsChosen) {
                            // Set to 1
                            $mModuleSubcluster->IsChosen = 1;
                            $mModuleSubcluster->save();
                        }
                    } else {
                        // Check if 1 in DB
                        if ($mModuleSubcluster->IsChosen) {
                            $mModuleSubcluster->IsChosen = 0;
                            $mModuleSubcluster->save();
                        }
                    }
                }

                // TODO: add checking
                jsonResponse(true);


            } else {
                // Opens form to edit individual module.

                $mModule = Module::findById($id);
                $mSemesters = getSemesters();
                $mSubjects = getSubjects();
                $mSubclusters = getModuleSubclusters($id);

                $app->render("Kaukaras.admin/ajax/module/edit.php", [
                    'module' => $mModule,
                    'semesters' => $mSemesters,
                    'subjects' => $mSubjects,
                    'subclusters' => $mSubclusters,
                ]);
            }
        })->name('ajax/module/edit');
    });

    $app->group("/subcluster", function () use ($app) {
        $app->post("/add/:id", function (int $id = NULL) use ($app) {

            if (count($_POST) === 0) { // Show form.

                $app->render("Kaukaras.admin/ajax/subcluster/add.php", [

                ]);

            } else { // Parse form dialog data.

                $mSubCluster = new Cluster();
                $mSubCluster->Name = trim($app->request->params("name")); // Remove whitespace from start and end.
                $mSubCluster->cluster()->associate($id);
                if ($mSubCluster->save()) { // Save SubCluster
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Nepavyko išsaugoti");
                }

            }

        })->name('ajax/subcluster/add');

        $app->post("/edit/:id", function (int $id = NULL) use ($app) {
            if (!isset($id)) {
                echo json_encode([
                    "success" => false,
                    "msg" => "Pogrupis tokiu ID neegzistuoja!"
                ]);
            }
            if (isset($_POST['action'])) {
                // Form submitted through edit

                if ($_POST['action'] != "edit") {
                    echo json_encode([
                        "success" => false,
                        "msg" => "Paduoti neteisingi parametrai"
                    ]);
                }

                // Get submitted field name.
                $mSubClusterName = $app->request->params("name");

                $mSubcluster = Cluster::findById($id);
                $mSubcluster->Name = $mSubClusterName;

                if ($mSubcluster->save()) {
                    jsonResponse(true);
                } else {
                    jsonResponse(false, "Klaida išsaugant pogrupį!");
                }

            } else {
                // Opens form to edit individual lecture.

                $mSubcluster = Cluster::findById($id);

                $app->render("Kaukaras.admin/ajax/subcluster/edit.php", [
                    'subcluster' => $mSubcluster,
                ]);
            }
        })->name('ajax/subcluster/edit');
    });

    $app->group("/module_subcluster", function () use ($app) {
        $app->post("/add/:id", function (int $id = NULL) use ($app) {

            if (count($_POST) === 0) { // Show form.

                $mSubClusters = getSubClusters();

                $app->render("Kaukaras.admin/ajax/module_subcluster/add.php", [
                    'subclusters' => $mSubClusters
                ]);

            } else { // Parse form dialog data.

                $mSubclusters = $app->request->params("subclusters");

                if ($mSubclusters === NULL) {
                    jsonResponse(false, "Pasirinkite bent vieną pogrupį");
                }

                foreach ($mSubclusters as $val) {
                    $mModuleSubcluster = new ModuleCluster();
                    $mModuleSubcluster->module()->associate($id);
                    $mModuleSubcluster->subCluster()->associate((int)$val);

                    $mIsChosen = isset($_POST['is_chosen_' . $val]);
                    $mModuleSubcluster->IsChosen = $mIsChosen;
                    $mModuleSubcluster->save();
                }

                jsonResponse(true);

            }

        })->name('ajax/module_subcluster/add');
    });
});

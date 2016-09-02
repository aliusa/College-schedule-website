<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016.01.25
 * Time: 17:51
 */

use Kaukaras\Models\Classroom;
use Kaukaras\Models\Cluster;
use Kaukaras\Models\Faculty;
use Kaukaras\Models\Lecture;
use Kaukaras\Models\Module;
use Kaukaras\Models\ModuleCluster;
use Kaukaras\Models\Professor;
use Kaukaras\Models\RecurringTask;
use Kaukaras\Models\Semester;

$app->group("/ajax", function () use ($app) {
    $app->group("/settings", function () use ($app) {
        $app->group("/actions", function () use ($app) {

            $app->post("/delete", function () use ($app) {
                $mTable = $_POST['table'];
                $mPKName = $_POST['pk_name'];
                $mPK = (int)$_POST['pk'];

                if ("lecture" === $mTable) {
                    /*TODO: on delete check if RecurringTask Date fields needs to be updated.*/
                    if (Lecture::findById($mPK)->delete())
                        jsonResponse(true);
                } elseif ("recurringtask" === $mTable) {

                    /*Get all depending lectures.*/
                    $lectures = RecurringTask::findById($mPK)->lecture()->getResults();

                    /*Iterate Lectures and delete them.*/
                    foreach ($lectures as $key => $val) {
                        if (!$val->delete())
                            jsonResponse(false, "Nepavyko ištrinti paskaitos #" . $val->id);
                    }

                    /*Find parent Task of RecurringTask*/
                    $mModule = Module::findById(RecurringTask::findById($mPK)->ModuleId);

                    /*Delete RecurringTask*/
                    if (!RecurringTask::findById($mPK)->delete())
                        jsonResponse(false, "Nepavyko ištrinti tvarkaraščio kortelės (RecurringTask)");

                    /*Delete Module if it has no more childs.*/
                    if (count($mModule->recurringTask()->getResults()) === 0) {
                        /*Delete Task*/
                        if (!$mModule->delete())
                            jsonResponse(false, "Nepavyko ištrinti modulio");
                        else
                            jsonResponse(true);
                    } else {
                        jsonResponse(true);
                    }
                } elseif ("cluster" === $mTable) {
                    /*Gets all belonging SubClusters*/
                    $mSubClusters = Cluster::findById($mPK)->subCluster()->getResults();

                    /*Init. Number of Lectures that Cluster with all it's SubClusters has.*/
                    $mLectures = 0;

                    foreach ($mSubClusters as $keyS => $valS) {

                        /*Gets all RecurringTask's with that SubCluster.*/
                        $RecurringTask = RecurringTask::getBySubClusterId($valS->SubClusterId);

                        foreach ($RecurringTask as $keyR => $valR) {

                            /*Count each Lecture in each RecurringTask*/
                            $mLectures += Lecture::getByRecurringTaskId($valR->RecurringTaskId)->count();
                        }
                    }

                    if ($mLectures != 0) {
                        jsonResponse(false, "Grupė turi " . $mLectures . " paskaitas (-ų), tad grupės negalima ištrinti.");
                    } else {

                        foreach ($mSubClusters as $keyS => $valS) {
                            /*Delete each SubCluster*/
                            $valS->delete();
                        }

                        /*Delete Cluster*/
                        if (Cluster::findById($mPK)->delete())
                            jsonResponse(true, "Sėkmingai ištrinta");
                        else
                            jsonResponse(false, "Nepavyko ištrinti grupės");
                    }

                } elseif ("professor" === $mTable) {

                    $mProfessor = Professor::findById($mPK);

                    $mLectures = Lecture::getByProfessorId($mProfessor->ProfessorId);

                    if ($mLectures->count() != 0) {
                        jsonResponse(false, "Dėstytojas turi " . $mLectures->count() . " paskaitas (-ų), tad jo negalima ištrinti.");
                    } else {
                        if ($mProfessor->delete())
                            jsonResponse(true, "Sėkmingai ištrinta");
                        else
                            jsonResponse(false, "Nepavyko ištrinti dėstytojo");
                    }
                } elseif ("classroom" === $mTable) {

                    $mClassroom = Classroom::findById($mPK);
                    $mDeleted = $mClassroom->delete();

                    if ($mDeleted) {
                        jsonResponse(true, "Sėkmingai ištrinta");
                    } else {
                        jsonResponse(false, "Nepavyko ištrinti auditorijos. Galbūt auditorija turi priskirtos įrangos arba paskaitų?");
                    }
                } else if ("module" === $mTable) {
                    $mModule = Module::findById($mPK);
                    $mModuleSubcluster = ModuleCluster::findByModuleId($mModule->ModuleId);

                    //var_dump($mModuleSubcluster);
                    foreach ($mModuleSubcluster as $key => $val) {
                        //var_dump($val);
                        $val->delete();
                    }

                    if ($mModule->delete()) {
                        jsonResponse(true, "Sėkmingai ištrinta");
                    }
                } else if ("module_subcluster" === $mTable) {
                    $mModuleSubcluster = ModuleCluster::findById($mPK);
                    $mModule = Module::findById($mModuleSubcluster->ModuleId);

                    // Check if moduleSubcluster has any RecurringTask
                    $mRecurringTaskCount = count($mModuleSubcluster->recurringTask()->getResults());

                    if ($mRecurringTaskCount > 0) {
                        // Has RecurringTask = do not delete
                        jsonResponse(false, "Pogrupis turi tvarkaraščio korteles. Negalima ištrinti. Pirmiau ištrinkite tos grupės/pogrupio tvarkaraščių korteles.");
                    } else {
                        // Delete this ModuleSubcluster
                        $deletedModuleSubCluster = $mModuleSubcluster->delete();

                        // Check if Module has more ModuleSubcluster
                        $mModuleSubclusterCount = count($mModule->moduleSubcluster()->getResults());

                        if ($mModuleSubclusterCount == 0) {
                            $mModule->delete();
                        }

                        // TODO: check if module was successfully deleted.

                        if ($deletedModuleSubCluster) {
                            jsonResponse(true, "Pogrupis sėkmingai ištrintas");
                        }
                    }
                } else if ("faculty" === $mTable) {
                    $mFaculty = Faculty::findById($mPK);

                    // TODO: check if has classrooms, clusters.

                    if ($mFaculty->delete()) {
                        jsonResponse(true);
                    } else {
                        jsonResponse(false, "Neištrinta. Įsitikinkite, kad fakultetas neturi priskirtų auditorijų, grupių.");
                    }

                } else {
                    jsonResponse(false, "Nurodyta bloga lentelė");
                }
            });


            $app->post("/reorder", function () use ($app) {
                $mRecords = $_POST['records'];
                $ids = explode(',', $_POST['ids']);

                if ("semesters" === $mRecords) {

                    $mSemester = Semester::getSemesters();

                    foreach ($mSemester as $key => $value) {
                        $value->SortOrder = $ids[$key];
                        $value->save();
                    }
                    jsonResponse(true);
                }
            })->setName("ajax/settings/actions/reorder");

        });
    });
});
<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.12
 * Time: 21:12
 */

// abstract
include '../app/Kaukaras/Models/Entity.php';

include '../app/Kaukaras/Models/Classroom.php';
include '../app/Kaukaras/Models/Cluster.php';
include '../app/Kaukaras/Models/Lecture.php';
include '../app/Kaukaras/Models/Option.php';
include '../app/Kaukaras/Models/OptionDetails.php';
include '../app/Kaukaras/Models/Professor.php';
include '../app/Kaukaras/Models/RecurringTask.php';
include '../app/Kaukaras/Models/Semester.php';
include '../app/Kaukaras/Models/Subject.php';
include '../app/Kaukaras/Models/Module.php';
include '../app/Kaukaras/Models/User.php';
include '../app/Kaukaras/Models/LogAction.php';
include '../app/Kaukaras/Models/LogActionDetails.php';
include '../app/Kaukaras/Models/Equipment.php';
include '../app/Kaukaras/Models/Classroom_Equipment.php';
include '../app/Kaukaras/Models/ModuleCluster.php';
include '../app/Kaukaras/Models/Professor_Semester.php';
include '../app/Kaukaras/Models/Faculty.php';
include '../app/Kaukaras/Models/Params.php';
include '../app/aliuscore/Calendar.php';
include '../app/aliuscore/Utils.php';

use Illuminate\Database\Capsule\Manager;

$app->get("/", function () use ($app) {

    cacheLong();

    $mFaculties = Manager::
    table('faculty')
        ->select(
            'FacultyId'
            , 'Name' // Faculty Name
        )
        //->orderBy('SortOrder')
        ->get();

    foreach ($mFaculties as $key => $val) {
        // Query All Clusters.
        $cluster = Manager::
        table("cluster as cl")
            ->select(
                'cl.ClusterId'
                , 'cl.Name' // Cluster name
            )
            ->selectRaw('Option_Name(cl.FieldId) AS FieldName')// Used for grouping
            ->where('cl.FacultyId', '=', $val->FacultyId)
            ->where('cl.IsActive', '=', 1)/* All active */
            //->orderBy('od.SortOrder') // Order Faculties
            ->orderBy('cl.StudyFormId')// Order StudyForm
            ->orderBy('cl.Name')// Order Clusters
            ->get();

        $arr = [];
        // Get unique Fields of all Clusters.
        foreach ($cluster as $ke => $va) {
            if (!in_array($va->FieldName, $arr))
                $arr[] = $va->FieldName;
        }

        $val->fields = null;
        foreach ($cluster as $ke => $va) {
            // Ciklina kiekvieną specialybės pavadinimą
            foreach ($arr as $k => $v) {
                if ($v === $va->FieldName) {
                    // Įrašo tą Grupės objektą į specialybės objektą.
                    $val->fields[$k]->groups[] = $va;
                    // name - Specialybės pavadinimas
                    $val->fields[$k]->Name = $v;
                }
            }
        }
    }

    $app->render('Kaukaras/index.php', [
        'faculties' => $mFaculties
    ]);

})->name('index');
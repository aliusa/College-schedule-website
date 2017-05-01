<?php

namespace App\Http\Controllers;

use App\Cluster;
use App\Faculty;
use App\OptionsDetails;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // Get Faculties
        $faculties = Faculty::getAll()->each(function (Faculty $faculty, $key) {

            // Group Clusters by Fields
            $fields = $faculty->getActiveClusters()->sortBy(function (Cluster $cluster) {
                return $cluster->name;
            })->groupBy(function (Cluster $cluster) {
                return $cluster->field_id;
            })->toArray(); // Convert to array

            // To get Field names
            array_walk($fields, function (array &$item, int $key) {
                $temp = $item;
                $item = [];
                $item['name'] = OptionsDetails::findById($key)->name;
                $item['clusters'] = $temp;
            });

            // Do not add fields if they don't have clusters
            if (!!count($fields)) {
                $faculty->fields = $fields;
            }
        })->reject(function (Faculty $faculty) {
            // Remove faculties with 0 fields
            return !count($faculty->fields);
        });

        return view('public.index', [
            'faculties' => $faculties
        ]);
    }
}

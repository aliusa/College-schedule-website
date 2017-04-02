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
            $fields = $faculty->clusters()->groupBy(function (Cluster $cluster) {
                return $cluster->field_id;
            })->toArray(); // Convert to array

            // To get Field names
            array_walk($fields, function (&$item, $key) {
                $temp = $item;
                $item = [];
                $item['name'] = OptionsDetails::findById($key)->name;
                $item['clusters'] = $temp;
            });
            $faculty->fields = $fields;
        });

        return view('public.index', [
            'faculties' => $faculties
        ]);
    }
}

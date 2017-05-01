<?php

namespace App\Http\Controllers;

use App\Cluster;

class GroupController extends Controller
{
    public function show(Cluster $cluster)
    {
        $schedules = [];

        return view('public.group', [
            'schedules' => $schedules
            ,'group'=>$cluster
        ]);
    }
}

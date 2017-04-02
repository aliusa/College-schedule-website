<?php

namespace App\Http\Controllers;

use App\Cluster;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function test()
    {
        //dd(Faculty::findById(1)->getActiveClusters());

        dd(Cluster::getActiveClusters()->groupBy(function (Cluster $cluster) {
            return intval($cluster->field_id);
        }));


        die;
        $data = ['v', 'a', 'n', 'd', 'a'];
        Excel::create('test', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('html');
    }
}

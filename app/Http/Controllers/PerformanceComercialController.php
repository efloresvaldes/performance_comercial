<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultantModel;

class PerformanceComercialController extends Controller
{
    
    public function performanceComercialHome(){

         $consultants = ConsultantModel::getConsultants();
         return view('app.con_performance',['consultants'=>$consultants]);

    }
    public function test(){
        return json_encode(ConsultantModel::getConsultants());
    }
}

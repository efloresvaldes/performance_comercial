<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultantModel;

class PerformanceComercialController extends Controller
{

    public function home(){

      return $this->redirect('/con_desempenho');

    }
    
    public function performanceComercialHome(){

         $consultants = ConsultantModel::getConsultants();
         return view('app.performance_comercial.con_performance',['consultants'=>$consultants]);

    }

    public function performanceComercialReport(Request $request){
        
     
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $consultantsReq = $request->consultants;
        $consultantModel = new ConsultantModel();
        $performance_comercial = [];
        foreach($consultantsReq as $consultant){
            $performance_comercial_by_consultant = $consultantModel->getPerformanceComercial($startDate,$endDate,$consultant);
            array_push($performance_comercial,$performance_comercial_by_consultant);
        }
        
        return view('app.performance_comercial.report',['consultants'=>$performance_comercial]);

   }
    public function generateBarChart(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $consultantsReq = $request->consultants;

        $consultantModel = new ConsultantModel();

        $graficData = $consultantModel->getBarLineChartInfoGeneral($startDate,$endDate,$consultantsReq);

        return json_encode($graficData);
    }

    public function generatePieChart(Request $request){
        
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $consultantsReq = $request->consultants;

        $consultantModel = new ConsultantModel();

        $graficData = $consultantModel->getPieChartInfoGeneral($startDate,$endDate,$consultantsReq);

        
        return json_encode($graficData);
    }
}

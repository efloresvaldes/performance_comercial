<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\CustomClass\PerformanceComercial;


class ConsultantModel
{
    /**
     * Get a list of consultants.
     *
     */
    public static function getConsultants()
    {

        $consultants = DB::table('cao_usuario')
            ->join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
            ->select('cao_usuario.co_usuario as user_name', 'cao_usuario.no_usuario as fullname')
            ->where('permissao_sistema.co_sistema','=','1')
            ->where('permissao_sistema.in_ativo','=','S')
            ->where(
                function($query) {
                  return $query
                         ->where('permissao_sistema.co_tipo_usuario', '=', '0')
                         ->orWhere('permissao_sistema.co_tipo_usuario', '=', '1')
                         ->orWhere('permissao_sistema.co_tipo_usuario', '=', '2');
                 })
            ->get();

        return $consultants;
    }

    /**
     * Get performance comercial 
     *
     */
    public  function getPerformanceComercial($startDate,$endDate, $username)
    {
        $dateInterval = $this->calculateDatesInterval($startDate,$endDate);
      
        $result= [];
        $result [0]= $this->getConsultantName($username) ;  
        $resPC = [] ;     
        foreach($dateInterval as $dI){
            $dI = explode('-',$dI);

            $netIncome = $this->getNetIncome($dI[0],$dI[1], $username);

            $fixedCost = $this->getFixedCost($username);
    
            $commission = $this->getCommission($dI[0],$dI[1], $username);
    
            $profit = $netIncome - ($fixedCost + $commission);

            $pc =  new PerformanceComercial($dI[0].'/'.$dI[1], $netIncome, $fixedCost, $commission, $profit);
    
            array_push($resPC,$pc);
        }
        array_push($result,$resPC);
        
        return $result;

    }

    public function  getBarLineChartInfoGeneral($startDate,$endDate, $usernames){

        $result = [];
        $sumFixedCost =0;
        $grData = [];
        foreach($usernames as $user){
              $values = $this->getBarLineChartInfoIndividual($startDate,$endDate,$user);
              $sumFixedCost+= $this->getFixedCost($user);
              array_push($grData,$values);
        }
        $average = $sumFixedCost/count($usernames);
        array_push($result,$average);
        array_push($result,$grData);

        return $result;
    
    }

    private function getBarLineChartInfoIndividual($startDate,$endDate, $username){

        $dateInterval = $this->calculateDatesInterval($startDate,$endDate);

        $result= [];
        $result [0]= $this->getConsultantName($username) ; 
        $resPC = [] ;     
        foreach($dateInterval as $dI){
            $dI = explode('-',$dI);

            $netIncome = $this->getNetIncome($dI[0],$dI[1], $username);

            $pc =  new PerformanceComercial($dI[0].'/'.$dI[1], $netIncome,0, 0, 0);

            array_push($resPC,$pc);
        }
        array_push($result,$resPC);
        
        return $result;
    }

    public function getPieChartInfoGeneral($startDate,$endDate,$usernames){
        
        $result = [];
        $result[0] = 0;
      
        $sumNetIncome =0;
       
        $valuesTemp =[];
        /*
         * get the total of net incomes to calculate percentage 
         * 
         */
        foreach($usernames as $user){
            
              $values = $this->getPieChartInfoIndividual($startDate,$endDate,$user);
              $sumNetIncome+= $values[1];
              array_push($valuesTemp, $values);
              
        }
        foreach($valuesTemp as $val){
            $percentage = 0;
            $grData = [];
            $totalConsultantNetIncome = $val[1];
            if($sumNetIncome != 0){
                $percentage = $totalConsultantNetIncome*100/$sumNetIncome;
            }
            array_push($grData, $percentage);
            array_push($grData, $val[0]);
           
            array_push($result,$grData);
           
        }
        $result[0] = $sumNetIncome;
    
        return $result;
    }
    private function getPieChartInfoIndividual($startDate,$endDate,$username){
        $dateInterval = $this->calculateDatesInterval($startDate,$endDate);

        $result= [];
        $result [0]= $this->getConsultantName($username) ; 
        $resPC = [] ; 
        $netIncomeTotal = 0;    
        foreach($dateInterval as $dI){
            $dI = explode('-',$dI);
            $netIncomeTotal += $this->getNetIncome($dI[0],$dI[1], $username);
            
        }
        array_push($result,$netIncomeTotal);
       
        return $result;
    }

    /**
     * Get a list of consultants.
     *
     */
    private function getNetIncome($month,$year, $username)
    {

        $netIncome = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->whereMonth('cao_fatura.data_emissao', '=', $month)
            ->whereYear('cao_fatura.data_emissao', '=', $year)
            ->where('cao_os.co_usuario', '=', $username)
            ->sum(DB::raw('cao_fatura.valor-(cao_fatura.valor*cao_fatura.total_imp_inc/100)'));



        return $netIncome;
    }

    private function getFixedCost($username)
    {

        $fixedCost = DB::table('cao_salario')
            ->where('cao_salario.co_usuario', '=', $username)
            ->select('cao_salario.brut_salario')
            ->first();
            if($fixedCost){
                return $fixedCost->brut_salario;
            }
            return 0;

       
    }

    private function getCommission($month, $year, $username)
    {
        $comission = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->whereMonth('cao_fatura.data_emissao', '=', $month)
            ->whereYear('cao_fatura.data_emissao', '=', $year)
            ->where('cao_os.co_usuario', '=', $username)
            ->sum(DB::raw('(cao_fatura.valor-(cao_fatura.valor*cao_fatura.total_imp_inc/100))*cao_fatura.comissao_cn/100'));

        return $comission;
    }

    private function getConsultantName($username){
         $usuario = DB::table('cao_usuario')
         ->where('cao_usuario.co_usuario','=',$username)
         ->select('cao_usuario.no_usuario')->first();

         if($usuario)
            return $usuario->no_usuario;
        return "";

    }
     private function calculateDatesInterval($startDate,$endDate){
         $startDate = explode('/',$startDate);
         $endDate = explode('/',$endDate);

        $datetime1 = date_create($startDate[1].'-'.$startDate[0].'-01');
        $datetime2 = date_create($endDate[1].'-'.$endDate[0].'-01');
        $interval =  $datetime1->diff($datetime2);//date_diff($datetime1, $datetime2);
        $months = intval($interval->format('%m'));

        $datesInterval = [];
        array_push($datesInterval,intval($startDate[0]).'-'.intval($startDate[1]));
        $i = 1;
        $monthActual = intval($startDate[0]);
        $yearActual = intval($startDate[1]);
        while($i <= $months){
             if($monthActual == 12){
                $yearActual++;
                $monthActual = 1;
             }
             else {
                $monthActual++;
             }
             array_push($datesInterval,$monthActual.'-'.$yearActual);
             $i++;

        }

       return $datesInterval;
    
     }
    
}

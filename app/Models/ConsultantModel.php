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
    public  function getPerformanceComercial($month, $username)
    {

        $netIncome = $this->getNetIncome($month, $username);

        $fixedCost = $this->getFixedCost($username);

        $commission = $this->getCommission($month, $username);

        $profit = $netIncome - ($fixedCost + $commission);

        $performance_comercial = new PerformanceComercial($month, $netIncome, $fixedCost, $commission, $profit);

        return $performance_comercial;
    }

    /**
     * Get a list of consultants.
     *
     */
    private function getNetIncome($month, $username)
    {

        $netIncome = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->whereMonth('cao_fatura.data_emissao', '=', $month)
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

        return $fixedCost->brut_salario;
    }

    private function getCommission($month, $username)
    {

        $comission = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->whereMonth('cao_fatura.data_emissao', '=', $month)
            ->where('cao_os.co_usuario', '=', $username)
            ->sum(DB::raw('(cao_fatura.valor-(cao_fatura.valor*cao_fatura.total_imp_inc/100))*cao_fatura.comissao_cn/100'));

        return $comission;
    }
}

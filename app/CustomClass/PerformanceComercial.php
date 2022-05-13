<?php

namespace App\CustomClass;

class PerformanceComercial
{
    protected $month;
    protected $net_income;
    protected $fixed_cost;
    protected $commission;
    protected $profit;

    public function __construct(string $month, float $net_income, float $fixed_cost, float $commission, float $profit)
    {
        $this->month = $month;
        $this->net_income = number_format($net_income, 2, ',', '.');
        $this->fixed_cost =number_format($fixed_cost, 2, ',', '.');
        $this->commission = number_format($commission, 2, ',', '.');
        $this->profit = number_format($profit, 2, ',', '.');
    }

    public function getMonth(){
        return $this->month;
    }

    public function getNetIncome(){
        return $this->net_income;
    }
    public function getFixedCost(){
        return $this->fixed_cost;
    }
    public function getComission(){
        return $this->commission;
    }
    public function getProfit(){
        return $this->profit;
    }

}
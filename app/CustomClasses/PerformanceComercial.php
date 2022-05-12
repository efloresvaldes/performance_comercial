<?php

namespace App\CustomClass;

class PerformanceComercial
{
    protected $month;
    protected $net_income;
    protected $fixed_cost;
    protected $commission;
    protected $profit;

    public function __construct(string $month, string $net_income, string $fixed_cost, string $commission, string $profit)
    {
        $this->$month = $month;
        $this->$net_income = $net_income;
        $this->$fixed_cost = $fixed_cost;
        $this->$commission = $commission;
        $this->$profit = $profit;
    }

}
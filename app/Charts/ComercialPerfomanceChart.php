<?php

namespace App\Charts;


use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Http\Request;
use khill\Lavacharts;

class ComercialPerfomanceChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}

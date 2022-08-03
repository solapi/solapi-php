<?php

namespace Nurigo\Solapi\Models\Response;

class GetStatisticsResponse
{
    /**
     * @var int
     */
    public $balance;

    /**
     * @var int
     */
    public $point;

    /**
     * @var int
     */
    public $monthlyBalanceAvg;

    /**
     * @var int
     */
    public $monthlyPointAvg;

    /**
     * @var StatisticsMonthPeriod[]
     */
    public $monthPeriod;

    /**
     * @var MessageType
     */
    public $total;

    
}
<?php

namespace Nurigo\Solapi\Models\Response;

class StatisticsMonthPeriod
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var int
     */
    public $balance;

    /**
     * @var int
     */
    public $balanceAvg;

    /**
     * @var int
     */
    public $point;

    /**
     * @var int
     */
    public $pointAvg;

    /**
     * @var StatisticsDayPeriod[]
     */
    public $dayPeriod;

    /**
     * @var object[]
     */
    public $refund;

    /**
     * @var object
     */
    public $total;

    /**
     * @var object
     */
    public $successed;

    /**
     * @var object
     */
    public $failed;
}
<?php

namespace Nurigo\Solapi\Models\Response;

class StatisticsDayPeriod
{
    /**
     * @var string
     */
    public $month;

    /**
     * @var int
     */
    public $balance;

    /**
     * @var MessageType[]
     */
    public $statusCode;

    /**
     * @var object
     */
    public $refund;

    /**
     * @var MessageType
     */
    public $total;

    /**
     * @var MessageType
     */
    public $successed;

    /**
     * @var MessageType
     */
    public $failed;
}

<?php

namespace Nurigo\Solapi\Models\Response;

class GroupCount
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $sendTotal;

    /**
     * @var int
     */
    public $sentFailed;

    /**
     * @var int
     */
    public $sentSuccess;

    /**
     * @var int
     */
    public $sentPending;

    /**
     * @var int
     */
    public $sentReplacement;

    /**
     * @var int
     */
    public $refund;

    /**
     * @var int
     */
    public $registeredFailed;

    /**
     * @var int
     */
    public $registeredSuccess;
}
<?php

namespace Nurigo\Solapi\Models\Response;

class GroupCount
{
    /**
     * @var int|null
     */
    public $total;

    /**
     * @var int|null
     */
    public $sendTotal;

    /**
     * @var int|null
     */
    public $sentFailed;

    /**
     * @var int|null
     */
    public $sentSuccess;

    /**
     * @var int|null
     */
    public $sentPending;

    /**
     * @var int|null
     */
    public $sentReplacement;

    /**
     * @var int|null
     */
    public $refund;

    /**
     * @var int|null
     */
    public $registeredFailed;

    /**
     * @var int|null
     */
    public $registeredSuccess;

    /**
     * @param \stdClass|null $value
     */
    public function __construct($value = null)
    {
        $this->total = $value->total ?? null;
        $this->sendTotal = $value->sentTotal ?? $value->sendTotal ?? null;
        $this->sentFailed = $value->sentFailed ?? null;
        $this->sentSuccess = $value->sentSuccess ?? null;
        $this->sentPending = $value->sentPending ?? null;
        $this->sentReplacement = $value->sentReplacement ?? null;
        $this->refund = $value->refund ?? null;
        $this->registeredFailed = $value->registeredFailed ?? null;
        $this->registeredSuccess = $value->registeredSuccess ?? null;
    }
}

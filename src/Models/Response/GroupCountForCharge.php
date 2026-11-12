<?php

namespace Nurigo\Solapi\Models\Response;

class GroupCountForCharge
{

    /**
     * @var object|null
     */
    public $sms;

    /**
     * @var object|null
     */
    public $lms;

    /**
     * @var object|null
     */
    public $mms;

    /**
     * @var object|null
     */
    public $ata;

    /**
     * @var object|null
     */
    public $cta;

    /**
     * @var object|null
     */
    public $cti;

    /**
     * @var object|null
     */
    public $nsa;

    /**
     * @var object|null
     */
    public $rcs_sms;

    /**
     * @var object|null
     */
    public $rcs_lms;

    /**
     * @var object|null
     */
    public $rcs_mms;

    /**
     * @var object|null
     */
    public $rcs_tpl;

    /**
     * @param \stdClass|null $value
     */
    public function __construct($value = null)
    {
        $this->sms = $value->sms ?? null;
        $this->lms = $value->lms ?? null;
        $this->mms = $value->mms ?? null;
        $this->ata = $value->ata ?? null;
        $this->cta = $value->cta ?? (object) [];
        $this->cti = $value->cti ?? (object) [];
        $this->nsa = $value->nsa ?? null;
        $this->rcs_sms = $value->rcs_sms ?? null;
        $this->rcs_lms = $value->rcs_lms ?? null;
        $this->rcs_mms = $value->rcs_mms ?? null;
        $this->rcs_tpl = $value->rcs_tpl ?? null;
    }
}

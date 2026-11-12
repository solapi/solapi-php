<?php

namespace Nurigo\Solapi\Models\Response;

use Nurigo\Solapi\Libraries\ResponseMapper;

class GroupMessageResponse
{
    /**
     * @var GroupCount|null
     */
    public $count;

    /**
     * @var GroupCountForCharge|null
     */
    public $countForCharge;

    /**
     * @var CommonCashResponse|null
     */
    public $balance;

    /**
     * @var CommonCashResponse|null
     */
    public $point;

    /**
     * @var object|null
     */
    public $app;

    /**
     * @var object|null
     */
    public $log;

    /**
     * @var string|null 메시지 그룹 상태
     */
    public $status;

    /**
     * @var bool|null 중복 수신번호 허용 여부
     * true로 설정하면 중복 수신번호를 허용함
     */
    public $allowDuplicates;

    /**
     * @var bool|null
     */
    public $isRefunded;

    /**
     * @var string|null 계정 고유번호
     */
    public $accountId;

    /**
     * @var string|null 마이사이트 마스터 계정 고유번호
     */
    public $masterAccountId;

    /**
     * @var string|null 메시지 그룹 ID
     */
    public $groupId;

    /**
     * @var array|null
     */
    public $price;

    /**
     * @var string|null 메시지 그룹 생성일시
     */
    public $dateCreated;

    /**
     * @var string|null 메시지 그룹 수정일시
     */
    public $dateUpdated;

    /**
     * @var string|null 메시지 그룹 예약일시
     */
    public $scheduledDate;

    /**
     * @var string|null 메시지 그룹 발송일시
     */
    public $dateSent;

    /**
     * @var string|null 메시지 그룹 발송 완료일시
     */
    public $dateCompleted;

    /**
     * @param \stdClass|null $value
     */
    public function __construct($value = null)
    {
        $this->count = ResponseMapper::mapObject($value->count ?? null, GroupCount::class);
        $this->countForCharge = ResponseMapper::mapObject($value->countForCharge ?? null, GroupCountForCharge::class);
        $this->balance = ResponseMapper::mapObject($value->balance ?? null, CommonCashResponse::class);
        $this->point = ResponseMapper::mapObject($value->point ?? null, CommonCashResponse::class);
        $this->app = $value->app ?? null;
        if (isset($this->app->profit) && is_object($this->app->profit)) {
            $this->app->profit->cta = $this->app->profit->cta ?? 0;
            $this->app->profit->cti = $this->app->profit->cti ?? 0;
        }
        $this->log = $value->log ?? null;
        $this->status = $value->status ?? null;
        $this->allowDuplicates = $value->allowDuplicates ?? null;
        $this->isRefunded = $value->isRefunded ?? null;
        $this->accountId = $value->accountId ?? null;
        $this->masterAccountId = $value->masterAccountId ?? null;
        $this->groupId = $value->groupId ?? null;
        $this->price = $value->price ?? null;
        $this->dateCreated = $value->dateCreated ?? null;
        $this->dateUpdated = $value->dateUpdated ?? null;
        $this->scheduledDate = $value->scheduledDate ?? null;
        $this->dateSent = $value->dateSent ?? null;
        $this->dateCompleted = $value->dateCompleted ?? null;
    }
}

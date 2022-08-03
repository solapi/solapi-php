<?php

namespace Nurigo\Solapi\Models\Response;

use stdClass;

class GroupMessageResponse
{
    /**
     * @var GroupCount
     */
    public $count;

    /**
     * @var GroupCountForCharge
     */
    public $countForCharge;

    /**
     * @var CommonCashResponse
     */
    public $balance;

    /**
     * @var CommonCashResponse
     */
    public $point;

    /**
     * @var object
     */
    public $app;

    /**
     * @var object
     */
    public $log;

    /**
     * @var string 메시지 그룹 상태
     */
    public $status;

    /**
     * @var bool 중복 수신번호 허용 여부
     * true로 설정하면 중복 수신번호를 허용함
     */
    public $allowDuplicates;

    /**
     * @var bool
     */
    public $isRefunded;

    /**
     * @var string 계정 고유번호
     */
    public $accountId;

    /**
     * @var string|null 마이사이트 마스터 계정 고유번호
     */
    public $masterAccountId;

    /**
     * @var string 메시지 그룹 ID
     */
    public $groupId;

    /**
     * @var array
     */
    public $price;

    /**
     * @var string 메시지 그룹 생성일시
     */
    public $dateCreated;

    /**
     * @var string 메시지 그룹 수정일시
     */
    public $dateUpdated;

    /**
     * @var string 메시지 그룹 예약일시
     */
    public $scheduledDate;

    /**
     * @var string 메시지 그룹 발송일시
     */
    public $dateSent;

    /**
     * @var string 메시지 그룹 발송 완료일시
     */
    public $dateCompleted;
}
<?php

namespace Nurigo\Solapi\Models\Request;

class GetStatisticsRequest
{
    /**
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $endDate;

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return GetStatisticsRequest
     */
    public function setStartDate(string $startDate): GetStatisticsRequest
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     * @return GetStatisticsRequest
     */
    public function setEndDate(string $endDate): GetStatisticsRequest
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMasterAccountId(): string
    {
        return $this->masterAccountId;
    }

    /**
     * @param string $masterAccountId
     * @return GetStatisticsRequest
     */
    public function setMasterAccountId(string $masterAccountId): GetStatisticsRequest
    {
        $this->masterAccountId = $masterAccountId;
        return $this;
    }

    /**
     * @var string
     */
    public $masterAccountId;
}
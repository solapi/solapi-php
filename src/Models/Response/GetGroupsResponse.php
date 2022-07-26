<?php

namespace Nurigo\Solapi\Models\Response;

class GetGroupsResponse
{
    /**
     * @var string
     */
    public $startKey;

    /**
     * @var string
     */
    public $nextKey;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var GroupMessageResponse[]
     */
    public $groupList;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->limit = $value->limit ?? null;
        $this->groupList = $value->groupList ?? null;
        $this->startKey = $value->startKey ?? null;
        $this->nextKey = $value->nextKey ?? null;
    }
}
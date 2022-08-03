<?php

namespace Nurigo\Solapi\Models\Request;

use DateTime;

class GetGroupsRequest
{
    /**
     * @var string
     */
    public $startKey;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var string|DateTime
     */
    public $startDate;

    /**
     * @var string|DateTime
     */
    public $endDate;
}
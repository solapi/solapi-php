<?php

use Nurigo\Solapi\Models\Request\GetStatisticsRequest;
use Nurigo\Solapi\Services\SolapiMessageService;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * 통계 조회 예제
 */
$messageService = new SolapiMessageService("ENTER_YOUR_API_KEY", "ENTER_YOUR_API_SECRET");

// 날짜 검색이 필요할 경우 아래 주석을 해제하여 검색해보세요!
$parameter = new GetStatisticsRequest();

// 날짜로 검색, startDate와 endDate가 반드시 같이 기입되어야 합니다!
// date_default_timezone_set("Asia/Seoul");
// $startDate = DateTime::createFromFormat("Y-m-d H:i:s", "2022-11-22 00:00:00")->format("c");
// $endDate = DateTime::createFromFormat("Y-m-d H:i:s", "2022-11-22 23:59:59")->format("c");
// $parameter->setStartDate($startDate);
// $parameter->setEndDate($endDate);

$response = $messageService->getStatistics($parameter);
print_r($response);

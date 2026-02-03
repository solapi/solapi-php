<?php

use Nurigo\Solapi\Services\SolapiMessageService;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * 충전 요금 조회 예제
 */
$messageService = new SolapiMessageService("ENTER_YOUR_API_KEY", "ENTER_YOUR_API_SECRET");
$response = $messageService->getBalance();

// 충전 요금(잔액) 조회
echo $response->balance . "\n";

// 잔여 포인트 조회
echo $response->point . "\n";
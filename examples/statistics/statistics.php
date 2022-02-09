<?php
/*
 * 통계 조회
 */
require_once("../../lib/message.php");

$data = new stdClass();
// 조회 시작 일시(ISO8601 포맷으로 입력)
$data->startDate = '2021-12-01T00:00:00+09:00';
// 조회 끝 일시(ISO8601 포맷으로 입력)
$data->endDate = '2021-12-31T23:59:59+09:00';

$res = request("GET", "/messages/v4/statistics", $data);

echo <<<EOT
서비스 이용 금액: {$res->balance}
비스 이용 포인트: {$res->point}
월 평균 서비스 이용 금액: {$res->monthlyBalanceAvg}
월 평균 서비스 이용 포인트: {$res->monthlyPointAvg}
일 평균 서비스 이용 금액: {$res->dailyBalanceAvg}
일 평균 서비스 이용 포인트: {$res->dailyPointAvg}
일 평균 전체 건수: {$res->dailyTotalCountAvg}
일 평균 성공 건수: {$res->dailySuccessedCountAvg}
일 평균 실패 건수: {$res->dailyFailedCountAvg}

EOT;
echo "환급정보: ";
print_r($res->refund);
echo "메시지 타입별 전체 건수: ";
print_r($res->total);
echo "메시지 타입별 성공 건수: ";
print_r($res->successed);
echo "메시지 타입별 실패 건수: ";
print_r($res->failed);

echo "월별 통계: ";
print_r($res->monthPeriod);
echo "일별 통계: ";
print_r($res->dayPeriod);

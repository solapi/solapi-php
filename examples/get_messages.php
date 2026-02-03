<?php

use Nurigo\Solapi\Models\Request\GetMessagesRequest;
use Nurigo\Solapi\Services\SolapiMessageService;

require_once dirname(__DIR__) . '/vendor/autoload.php';


/**
 * 메시지(문자, 알림톡 모두 포함) 조회 예제
 * 반드시 발신번호/수신번호 형식은 01012345678 형식으로 입력해주셔야 합니다!
 */
$messageService = new SolapiMessageService("ENTER_YOUR_API_KEY", "ENTER_YOUR_API_SECRET");

// 필요한 검색 조건에 따라 주석들을 해제하여 응용해보세요!
$parameter = new GetMessagesRequest();

// 발신번호로 검색
// $parameter->setFrom("발신번호 입력");

// 수신번호로 검색
// $parameter->setTo("수신번호 입력");

// 조회할 건 수 지정
// $parameter->setLimit(1);

// 메시지 조회 시 나오는 nextKey로 페이지 조회
// $parameter->setStartKey("nextKey로 나온 값 입력");

// 그룹 ID로 조회
// $parameter->setGroupId("그룹 ID 입력");

// 메시지 ID로 조회
// $parameter->setMessageId("메시지 ID 입력");

// 메시지 ID 여러개 조회
// $parameter->setMessageIds([
//     "메시지 ID 입력",
//     "메시지 ID 입력"
// ]);

// 메시지 유형(알림톡: ATA, 단문 문자:SMS 등)으로 검색
// 유형에 대한 값은 아래 내용을 참고해주세요!
// SMS: 단문
// LMS: 장문
// MMS: 사진문자
// ATA: 알림톡
// CTA: 친구톡
// CTI: 이미지 친구톡
// NSA: 네이버 스마트알림
// RCS_SMS: RCS 단문
// RCS_LMS: RCS 장문
// RCS_MMS: RCS 사진문자
// RCS_TPL: RCS 템플릿문자
// $parameter->setType("조회 할 메시지 유형입력");

// 조회 할 상태코드 입력, 상태 코드 목록은 아래 페이지를 참고해주세요!
// https://developers.solapi.com/references/message-status-codes
// $parameter->setStatusCode("조회 할 상태코드 입력");

// 날짜로 검색, startDate와 endDate가 반드시 같이 기입되어야 합니다!
// date_default_timezone_set("Asia/Seoul");
// $startDate = DateTime::createFromFormat("Y-m-d H:i:s", "2022-11-22 00:00:00")->format("c");
// $endDate = DateTime::createFromFormat("Y-m-d H:i:s", "2022-11-22 23:59:59")->format("c");
// $parameter->setStartDate($startDate);
// $parameter->setEndDate($endDate);

$messages = $messageService->getMessages($parameter);
print_r($messages);

foreach ($messages->messageList as $key => $val) {
    echo "메시지ID: {$val->messageId}\n";
    echo "그룹ID: {$val->groupId}\n";
    echo "타입: {$val->type}\n";
    echo "국가: {$val->country}\n";
    echo "제목(LMS, MMS): {$val->subject}\n";
    echo "내용: {$val->text}\n";
    echo "발신번호: {$val->from}\n";
    echo "수신번호: {$val->to}\n";
    echo "상태(코드): {$val->statusCode}\n";
    echo "-----------------------------\n";
}
<?php
/*
 * 조회된 메시지목록 접근하여 세부항목 출력
 */
require_once("../../lib/message.php");

$res = get_messages();

foreach ($res->messageList as $key => $val) {
    echo "메시지ID: {$val->messageId}\n";
    echo "그룹ID: {$val->groupId}\n";
    echo "타입: {$val->type}\n";
    echo "국가: {$val->country}\n";
    echo "제목(LMS, MMS): {$val->subject}\n";
    echo "내용: {$val->text}\n";
    echo "발신번호: {$val->from}\n";
    echo "수신번호: {$val->to}\n";
    echo "수신시간: {$val->dateReceived}\n";
    echo "상태(처리상태): {$val->status}\n";
    echo "상태(코드): {$val->statusCode}\n";
    echo "상태(텍스트): {$val->reason}\n";
    echo "통신사: {$val->networkName}\n";
    print_r("로그: {$val->log}");
}

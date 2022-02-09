<?php
/*
 * 메시지 상태 코드로 조회
 */
require_once("../../lib/message.php");

$params = array(
    "statusCode" => '4000', // 발송 성공한 내역만 조회
);
$res = get_messages($params);
print_r($res);

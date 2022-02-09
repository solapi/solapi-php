<?php
/*
 * 수신번호로 조회
 */
require_once("../../lib/message.php");

$params = array(
    "to" => '수신번호 입력', // 조회할 수신번호 입력
);
$res = get_messages($params);
print_r($res);

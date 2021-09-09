<?php
/*
 * Step 1) 발신번호 등록
 */
require_once("../../lib/message.php");

// 등록하실 발신번호 입력
$phoneNumber = '01000000001';

$res = request("POST", "/senderid/v1/numbers", array("phoneNumber" => $phoneNumber));
print_r($res);

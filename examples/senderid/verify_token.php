<?php
/**
 * Step 3) 인증번호 확인
 * Step 2 과정에서 획득한 정보를 모두 입력하여 인증받습니다.
 */
require_once("../../lib/message.php");

// 전화번호 입력
$phoneNumber = '01000000001';

// Transaction ID 입력
$transactionId = 'cc4f482bcf167f69f2b15fcfd044f509';

// 음성으로 전달받은 인증번호 입력
$token = '1586';

$authInfo = array(
    'authType' => 'ARS',
    'extras' => array(
        'phoneNumber' => $phoneNumber
    ),
    'transactionId' => $transactionId,
    'token' => $token
);

$headers = array(
    'x-mfa-data: ' . json_encode($authInfo)
);

$path = sprintf('/senderid/v1/numbers/%s/authenticate', $phoneNumber);

$res = request("PUT", $path, null, $headers);
print_r($res);

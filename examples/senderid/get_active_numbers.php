<?php
/**
 * 활성화된 발신번호 목록 조회
 */
require_once("../../lib/message.php");

$res = request('GET', '/senderid/v1/numbers/active');
print_r($res);

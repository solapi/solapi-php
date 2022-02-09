<?php
/*
 잔액 조회
*/
require_once("../lib/message.php");
$res = get_balance();
echo "잔액: {$res->balance}, 포인트: {$res->point}";

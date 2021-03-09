<?php
/*
 * 메시지 조회
 */
require_once("../../lib/message.php");

$res = get_messages();
print_r($res);

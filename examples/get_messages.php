<?php
/*
 메시지 조회
*/
require_once("../lib/message.php");
$data = $data = new stdClass();
$data->limit = 1;
$res = get_messages($data);
print_r($res);

<?php
/*
 * 메시지 아이디로 조회
 */
require_once("../../lib/message.php");

$params = array(
    "messageId" => 'M4V20210309180637GRT4ZBYGQHCN8UF', // 조회할 메시지 아이디 입력
);
$res = get_messages($params);
print_r($res);

<?php
/*
 * 그룹아이디로 조회
 * 그룹의 모든 메시지 목록을 조회합니다.
 */
require_once("../../lib/message.php");

$params = array(
    "groupId" => 'G4V20210309180637P1RJKXZMV3X9PQC', // 조회 할 그룹 아이디 입력
);
$res = get_messages($params);
print_r($res);

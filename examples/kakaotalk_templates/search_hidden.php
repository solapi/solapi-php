<?php
/*
 * 숨김처리된 목록 조회
 */
require_once("../../lib/message.php");

$params = array(
    "limit" => 10, // 한 페이지에 불러올 목록 개수
    "isHidden" => "true" // false 입력 시 숨김처리되지 않은 목록 조회
);
print_r(request("GET", "/kakao/v1/templates", $params));

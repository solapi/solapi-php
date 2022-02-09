<?php
/*
 * 특정 채널에 등록된 템플릿 조회
 */
require_once("../../lib/message.php");

$params = array(
    "limit" => 10, // 한 페이지에 불러올 목록 개수
    "pfId" => "KA01PF190626020502205cl0mYSoplC1" // 조회 PFID 입력
);
print_r(request("GET", "/kakao/v1/templates", $params));

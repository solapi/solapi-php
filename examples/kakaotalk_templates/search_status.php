<?php
/*
 * 상태로 조회
 */
require_once("../../lib/message.php");

// 사용 가능한 템플릿 목록 읽어오기
$params = array(
    "limit" => 10, // 한 페이지에 불러올 목록 개수
    "status" => "APPROVED" // PENDING: 대기, INSPECTING: 검수중, APPROVED: 승인, REJECTED: 반려
);
print_r(request("GET", "/kakao/v1/templates", $params));

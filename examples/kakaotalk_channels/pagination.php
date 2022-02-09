<?php
/*
 * nextKey를 이용한 페이지 처리
 */
require_once("../../lib/message.php");

// 한 페이지에 불러올 목록 개수
$limit = 5;

// Page 1
$page1 = request("GET", "/kakao/v1/plus-friends", array(
    "limit" => $limit
));
print_r($page1);

// Page 2
$page2 = request("GET", "/kakao/v1/plus-friends", array(
    "limit" => $limit,
    "startKey" => $page1->nextKey
));
print_r($page2);

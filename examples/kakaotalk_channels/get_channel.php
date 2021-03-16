<?php
/*
 * 채널정보 조회
 */
require_once("../../lib/message.php");

// 조회할 채널의 PFID 입력
$pfId = "KA01PF190626020502205cl0mYSoplC1";

print_r(request("GET", "/kakao/v1/plus-friends/{$pfId}"));

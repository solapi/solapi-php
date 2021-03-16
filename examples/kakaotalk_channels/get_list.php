<?php
/*
 * 연동된 카카오톡채널의 목록을 조회합니다.
 * 파라메터 설명: https://docs.solapi.com/api-reference/kakao/getplusfriends#query-params
 */
require_once("../../lib/message.php");

print_r(request("GET", "/kakao/v1/plus-friends"));

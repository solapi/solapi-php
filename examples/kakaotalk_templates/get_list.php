<?php
/*
 * 등록된 템플릿 목록을 조회합니다.
 * 파라메터 설명: https://docs.solapi.com/api-reference/kakao/gettemplates#query-params
 */
require_once("../../lib/message.php");

print_r(request("GET", "/kakao/v1/templates"));

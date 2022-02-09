<?php
/*
 * 검색용 아이디로 검색
 */
require_once("../../lib/message.php");

print_r(request("GET", "/kakao/v1/plus-friends", array(
    "searchId" => "[조회할 검색용 아이디 입력]"
)));

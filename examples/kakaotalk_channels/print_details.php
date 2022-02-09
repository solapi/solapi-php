<?php
/*
 * 조회된 메시지목록 접근하여 세부항목 출력
 */
require_once("../../lib/message.php");

$res = request("GET", "/kakao/v1/plus-friends");

foreach ($res->friends as $key => $val) {
    echo "PFID: {$val->pfId}\n";
    echo "상태: {$val->status}\n";
    echo "채널 반려사유: {$val->reasonRejected}\n";
    echo "검색용 아이디: {$val->searchId}\n";
    echo "생성일: {$val->dateCreated}\n";
    echo "업데이트: {$val->dateUpdated}\n";
}

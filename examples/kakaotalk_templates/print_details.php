<?php
/*
 * 조회된 메시지목록 접근하여 세부항목 출력
 */
require_once("../../lib/message.php");

$res = request("GET", "/kakao/v1/templates");

foreach ($res->templateList as $key => $val) {
    echo "템플릿ID: {$val->templateId}\n";
    echo "PFID: {$val->pfId}";
    echo "템플릿명: {$val->name}\n";
    echo "내용: {$val->content}\n";
    echo "버튼\n";
    foreach ($val->buttons as $button) {
        echo "  버튼타입: {$button->buttonType}\n";
        echo "  버튼이름: {$button->buttonName}\n";
        echo "  모바일링크: {$button->linkMo}\n";
        echo "  PC링크: {$button->linkPc}\n";
        echo "  안드로이드링크: {$button->linkAnd}\n";
        echo "  iOS링크: {$button->linkIos}\n";
    }
    echo "숨김처리: {$val->isHidden}\n";
    echo "등록일: {$val->dateCreated}\n";
    echo "수정일: {$val->dateUpdated}\n";
}

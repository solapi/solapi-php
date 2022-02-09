<?php
/*
 * 템플릿 정보 조회
 */
require_once("../../lib/message.php");

// 조회할 템플릿 아이디 입력
$templateId = "KA01TP190919082245843Ek04mGUzRXB";

$res = request("GET", "/kakao/v1/templates/{$templateId}");

echo "템플릿ID: {$res->templateId}\n";
echo "PFID: {$res->pfId}";
echo "템플릿명: {$res->name}\n";
echo "버튼\n";
echo "내용: {$res->content}\n";
foreach ($res->buttons as $button) {
    echo "  버튼타입: {$button->buttonType}\n";
    echo "  버튼이름: {$button->buttonName}\n";
    echo "  모바일링크: {$button->linkMo}\n";
    echo "  PC링크: {$button->linkPc}\n";
    echo "  안드로이드링크: {$button->linkAnd}\n";
    echo "  iOS링크: {$button->linkIos}\n";
}
echo "숨김처리: {$res->isHidden}\n";
echo "등록일: {$res->dateCreated}\n";
echo "수정일: {$res->dateUpdated}\n";

<?php
/*
 * 최대 1만건의 알림톡(버튼)을 한번의 요청으로 발송 가능합니다.
 * 버튼 부분도 등록된 템플릿의 버튼과 버튼타입, 버튼이름, 링크URL이 100% 일치해야 합니다.
 * 버튼 종류(AL: 앱링크, WL: 웹링크, DS: 배송조회, BK: 키워드, MD: 전달, AC: 채널 추가, BC: 상담톡 전환, BT: 봇 전환)
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "to" => "01048597580",
        "from" => "029302266",
        "kakaoOptions" => array(
            "pfId" => "KA01PF190626020502205cl0mYSoplC1",
            "templateId" => "KA01TP210419012747059CtAoHvBCw4A",
            "variables" => array(
                "#{솔라피}" => "솔라피",
                "#{회원}" => "홍길동",
                "#{일일발송량 관리 페이지}" => "관리 페이지",
                "#{추가정보}" => "추가 정보",
                "#{link}" => "solapi.com/sms",
            )
        )
    )
);
print_r(send_messages($messages));

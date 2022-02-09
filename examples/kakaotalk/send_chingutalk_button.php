<?php
/*
 * 친구톡 보내기
 * 카카오톡채널 친구로 추가되어 있어야 친구톡 발송이 가능합니다.
 * 템플릿 등록없이 버튼을 포함하여 자유롭게 메시지 전송이 가능합니다.
 * 버튼 종류(AL: 앱링크, WL: 웹링크, BK: 키워드, MD: 전달)
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "템플릿 등록없이 버튼을 포함하여 자유롭게 메시지 전송이 가능합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "buttons" => array(
                array(
                    "buttonType" => "WL",
                    "buttonName" => "버튼 이름",
                    "linkMo" => "https://m.example.com",
                    "linkPc" => "https://example.com"
                )
            )
        )
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "text" => "실행 버튼을 눌러 이그젬플 어플리케이션을 실행시켜 주세요.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "buttons" => array(
                array(
                    "buttonType" => "AL",
                    "buttonName" => "실행 버튼",
                    "linkAnd" => "examplescheme://",
                    "linkIos" => "examplescheme://"
                )
            )
        )
    ),
    array(
        "to" => "01000010003",
        "from" => "029302266",
        "text" => "챗봇에게 키워드를 전달합니다. 버튼이름의 키워드가 그대로 전달됩니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "buttons" => array(
                array(
                    "buttonType" => "BK",
                    "buttonName" => "봇키워드"
                )
            )
        )
    ),
    array(
        "to" => "01000010004",
        "from" => "029302266",
        "text" => "안녕하세요 홍길동님, 상담이 필요하시면 상담요청하기 버튼을 눌러주시면 이 메시지가 상담원에게 그대로 전달됩니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "buttons" => array(
                array(
                    "buttonType" => "MD",
                    "buttonName" => "상담요청하기"
                )
            )
        )
    ),
    array(
        "to" => array("01000010006", "01000010007"), // 수신번호에 array 사용으로 같은 내용으로 여러명에게 전송
        "from" => "029302266",
        "text" => "모두님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "buttons" => array(
                array(
                    "buttonType" => "WL",
                    "buttonName" => "버튼 이름",
                    "linkMo" => "http://example.com"
                )
            )
        )
    )
);
print_r(send_messages($messages));

<?php
/*
 * 최대 1만건의 알림톡(버튼)을 한번의 요청으로 발송 가능합니다.
 * 버튼 부분도 등록된 템플릿의 버튼과 버튼타입, 버튼이름, 링크URL이 100% 일치해야 합니다.
 * 버튼 종류(AL: 앱링크, WL: 웹링크, DS: 배송조회, BK: 키워드, MD: 전달, AC: 채널 추가, BC: 상담톡 전환, BT: 봇 전환)
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "홍길동님 가입을 환영합니다.", // #{이름}님 가입을 환영합니다.
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
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
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
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
        "text" => "이그젬플 택배로 배송되었습니다. 배송조회를 눌러 확인해 보세요.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "DS",
                    "buttonName" => "배송조회"
                )
            )
        )
    ),
    array(
        "to" => "01000010004",
        "from" => "029302266",
        "text" => "챗봇에게 키워드를 전달합니다. 버튼이름의 키워드가 그대로 전달됩니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "BK",
                    "buttonName" => "봇키워드"
                )
            )
        )
    ),
    array(
        "to" => "01000010005",
        "from" => "029302266",
        "text" => "안녕하세요 홍길동님, 상담이 필요하시면 상담요청하기 버튼을 눌러주시면 이 메시지가 상담원에게 그대로 전달됩니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "MD",
                    "buttonName" => "상담요청하기"
                )
            )
        )
    ),
    array(
        "to" => "01000010006",
        "from" => "029302266",
        "text" => "안녕하세요 홍길동님, 채널추가 버튼을 눌러 친구추가하실 수 있습니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "AC",
                    "buttonName" => "채널추가"
                )
            )
        )
    ),
    array(
        "to" => "01000010007",
        "from" => "029302266",
        "text" => "안녕하세요 홍길동님, 상담톡으로 전환할 수 있습니다. (상담톡 서비스 사용 시 가능)",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "BC",
                    "buttonName" => "상담톡 전환"
                )
            )
        )
    ),
    array(
        "to" => "01000010008",
        "from" => "029302266",
        "text" => "안녕하세요 홍길동님, 챗봇 문의를 시작할 수 있습니다. (챗봇 사용 시 가능)",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "buttons" => array(
                array(
                    "buttonType" => "BT",
                    "buttonName" => "챗봇 문의"
                )
            )
        )
    ),
    array(
        "to" => array("01000010009", "01000010010"), // 수신번호에 array 사용으로 같은 내용으로 여러명에게 전송
        "from" => "029302266",
        "text" => "모두님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
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

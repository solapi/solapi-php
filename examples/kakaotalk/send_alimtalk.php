<?php
/*
 * 한번 요청으로 1만건의 알림톡 발송이 가능합니다.
 * 템플릿 내용에 변수가 있는 경우 반드시 변수: 값 을 입력하세요.
 */
require_once("../../lib/message.php");
$messages = array(
    // 템플릿 내에 변수가 없는 경우
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "variables" => new stdClass()
        )
    ),
    // 변수가 있는 경우
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "variables" => array(
                "#{변수1}" => "변수1의 값",
                "#{변수2}" => "변수2의 값",
                "#{변수3}" => "변수3의 값",
                "#{버튼링크1}" => "example.com/link1",
                "#{버튼링크2}" => "example.com/link2"
            )
        )
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "variables" => array(
                "#{변수1}" => "변수1의 값",
                "#{변수2}" => "변수2의 값",
                "#{변수3}" => "변수3의 값",
                "#{버튼링크1}" => "example.com/link1",
                "#{버튼링크2}" => "example.com/link2"
            ),
            "disableSms" => TRUE // 문자로 대체발송되지 않도록 합니다.
        )
    ),
    array(
        "to" => array("01000010004", "01000010005"), // array 사용으로 동일한 내용을 여러 수신번호에 전송 가능
        "from" => "029302266",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "variables" => array(
                "#{변수1}" => "변수1의 값",
                "#{변수2}" => "변수2의 값",
                "#{변수3}" => "변수3의 값",
                "#{버튼링크1}" => "example.com/link1",
                "#{버튼링크2}" => "example.com/link2"
            )
        )
    )
    // 계속해서 1만건 추가 가능.
);
print_r(send_messages($messages));

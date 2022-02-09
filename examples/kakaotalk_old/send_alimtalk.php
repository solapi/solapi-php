<?php
/*
 * 한번 요청으로 1만건의 알림톡 발송이 가능합니다.
 * 등록되어 있는 템플릿의 변수 부분을 제외한 나머지 부분(상수)은 100% 일치해야 합니다.
 * 템플릿 내용이 "#{이름}님 가입을 환영합니다."으로 등록되어 있는 경우 변수 #{이름}을 홍길동으로 치환하여 "홍길동님 가입을 환영합니다."로 입력해 주세요.
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "홍길동님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx"
        )
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "text" => "김길동님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx",
            "disableSms" => TRUE // 문자로 대체발송되지 않도록 합니다.
        )
    ),
    array(
        "to" => "01000010003",
        "from" => "029302266",
        "text" => "이길동님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx"
        )
    ),
    array(
        "to" => array("01000010004", "01000010005"), // array 사용으로 동일한 내용을 여러 수신번호에 전송 가능
        "from" => "029302266",
        "text" => "모두님 가입을 환영합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "templateId" => "KA01TP200323182345741y9yF20aabcx"
        )
    )
    // 계속해서 1만건 추가 가능.
);
print_r(send_messages($messages));

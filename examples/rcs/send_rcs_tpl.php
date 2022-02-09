<?php
/*
 * RCS SMS 메시지 1만건을 한번의 요청으로 발송할 수 있습니다.
 */
require_once('../../lib/message.php');
$messages = array(
    array(
        'to' => '01000000001',
        'from' => '029302266',
        'text' => '템플릿 기반 RCS를 발송합니다.',
        'rcsOptions' => array(
            'brandId' => 'BR.iIr12HZe3j', // RCSBizCenter(https://www.rcsbizcenter.com/)에서 발급받은 브랜드ID 입력
            'templateId' => 'RC01TP210727075536693B1z23GR7xWQ',
            'variables' => array(
                '{{변수1}}' => '변수1값',
                '{{변수2}}' => '변수2값',
                '{{변수3}}' => '변수3값'
            )
        )
    ),
    array(
        'to' => array("01000010002", "01000010003"), // 수신번호를 array로 입력하면 같은 내용을 여러명에게 보낼 수 있습니다.
        'from' => '029302266',
        'text' => '템플릿 기반 RCS를 발송합니다.',
        'rcsOptions' => array(
            'brandId' => 'BR.iIr12HZe3j',
            'templateId' => 'RC01TP210727075536693B1z23GR7xWQ',
            'variables' => array(
                '{{변수1}}' => '변수1값',
                '{{변수2}}' => '변수2값',
                '{{변수3}}' => '변수3값'
            )
        )
    ),
    // ...
    // 1만개 추가 가능
);
print_r(send_messages($messages));

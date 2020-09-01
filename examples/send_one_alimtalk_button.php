<?php
/*
 * 카카오톡 알림톡 버튼 1건 발송
 */
require_once("../lib/message.php");

$buttons = array((object)array('buttonType' => "WL", 'buttonName' => "버튼 이름", 'linkMo' => "http://example.com"));
print_r(send_one_alimtalk('KA01PF200323182344986oTFz9CIabcx', 'KA01TP200323182345741y9yF20aabcw', '01000010002', '029302266', '홍길동님 예약하신 객실명의 예약이 취소 되었습니다.', $buttons));

<?php
/*
 * 카카오톡 알림톡 1건 발송
 */
require_once("../lib/message.php");
print_r(send_one_alimtalk('KA01PF200323182344986oTFz9CIabcx', 'KA01TP200323182345741y9yF20aabcx', '01000010002', '029302266', '홍길동님 가입을 환영합니다.'));

<?php
/*
 * SMS 문자메시지 보내기
 */
require_once("../lib/message.php");
print_r(send_one_message("01000010002", "029302266", "한글 45자, 영자 90자 이하 입력되면 자동으로 SMS타입의 메시자가 발송됩니다."));

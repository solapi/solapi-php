<?php
/*
 * LMS 제목 예제
 * LMS 제목 입력 시 메시지 내용이 짧아도 LMS로 발송됩니다.
 */
require_once("../lib/message.php");
print_r(send_one_message("01000010002", "029302266", "문자메시지, 카카오톡, 네이버톡톡도 발송 가능합니다.", "LMS 제목"));

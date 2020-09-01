<?php
/*
 * LMS 발송 예제 
 * LMS 제목은 자동으로 내용 앞 부분에서 따옵니다. 제목 입력 예는 send_one_lms_subject.php 를 참고하세요.
 */
require_once("../lib/message.php");
print_r(send_one_message("01000010002", "029302266", "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"));

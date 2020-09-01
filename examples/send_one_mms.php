<?php
/*
 * MMS 이미지 발송 예제
 */
require_once("../lib/message.php");
$imageId = create_image(realpath("./testImage.jpg"));
print_r(send_one_message("01000010002", "029302266", "문자메시지, 카카오톡, 네이버톡톡도 발송가능합니다.", "MMS 제목", $imageId));

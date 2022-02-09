<?php
/*
  그룹메시지 발송(MMS 이미지)
*/
require_once("../../lib/message.php");

$groupId = create_group();
$imageId = create_image(realpath("./testImage.jpg"));
add_message($groupId, "01000010002", "029302266", "테스트 메시지", "MMS 제목", $imageId);
send_group($groupId);

<?php
/*
 * 친구톡 버튼 단건 발송
 */
require_once("../lib/message.php");
$buttons = array((object)array('buttonType' => "WL", 'buttonName' => "버튼 이름", 'linkMo' => "http://example.com"));
print_r(send_one_chingutalk("KA01PF200323182344986oTFz9CIabcx", "01000010002", "029302266", "친구톡 테스트", $buttons));

<?php
require_once(__DIR__ . "/../config.php");
$config = get_config();

function get_header() {
  global $config;
  $apiKey = $config["apiKey"];
  $apiSecret = $config["apiSecret"];
  date_default_timezone_set('Asia/Seoul');
  $date = date('Y-m-d\TH:i:s.Z\Z', time());
  $salt = uniqid();
  $signature = hash_hmac('sha256', $date.$salt, $apiSecret);
  return "Authorization: HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
}

function request($method, $resource, $data = false) {
  global $config;
  $url = "{$config['protocol']}://{$config['domain']}";
  if ($config['prefix']) $url .= $config['prefix'];
  $url .= $resource;

  try {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    switch ($method) {
      case "POST":
      case "PUT":
      case "DELETE":
        if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        break;
      default: // GET
        if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(get_header(), "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if (curl_error($curl)) {
      print curl_error($curl);
    }
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result);
  } catch (Exception $err) {
    return $err;
  }
}

function create_group_params($params) {
  return request("POST", "/messages/v4/groups", $params);
}

function create_group() {
  $params = new stdClass();
  $params->sdkVersion = 'PHP-SDK v4.0';
  $params->osPlatform = PHP_OS . ', PHP Version ' . phpversion();
  $result = request("POST", "/messages/v4/groups", $params);
  return $result->groupId;
}

function get_group_info($groupId) {
  return request("GET", "/messages/v4/groups/{$groupId}");
}

function get_group_list($limit = 20) {
  $data = new stdClass();
  $data->limit = $limit;
  return request("GET", "/messages/v4/groups", $data);
}

function delete_group($groupId) {
  return request("DELETE", "/messages/v4/groups/{$groupId}");
}

function add_message_params($groupId, $params) {
  return request("PUT", "/messages/v4/groups/{$groupId}/messages", $params);
}

function add_alimtalk($groupId, $pfId, $templateId, $to, $from, $text, $subject = null) {
  $kakaoOptions = new stdClass();
  $kakaoOptions->pfId = $pfId;
  $kakaoOptions->templateId = $templateId;
  $params = new stdClass();
  $message = new stdClass();
  $message->to = $to;
  $message->from = $from;
  $message->text = $text;
  $message->subject = $subject;
  $message->kakaoOptions = $kakaoOptions;
  $params->messages = json_encode(array($message));
  return add_message_params($groupId, $params);
}

function add_chingutalk($groupId, $pfId, $to, $from, $text, $subject = null) {
  $kakaoOptions = new stdClass();
  $kakaoOptions->pfId = $pfId;
  $params = new stdClass();
  $message = new stdClass();
  $message->to = $to;
  $message->from = $from;
  $message->text = $text;
  $message->subject = $subject;
  $message->kakaoOptions = $kakaoOptions;
  $params->messages = json_encode(array($message));
  return add_message_params($groupId, $params);
}

function add_message($groupId, $to, $from, $text, $subject = null, $imageId = null) {
  $params = new stdClass();
  $message = new stdClass();
  $message->text = $text;
  $message->to = $to;
  $message->from = $from;
  if ($subject) $message->subject = $subject;
  if ($imageId) $message->imageId = $imageId;
  $params->messages = json_encode(array($message));
  return add_message_params($groupId, $params);
}

function create_image_params($params) {
  return request("POST", "/storage/v1/files", $params);
}

function create_image($path) {
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $imageData = base64_encode($data);
  $params = new stdClass();
  $params->type = "MMS";
  $params->file = $imageData;
  $image_info = create_image_params($params);
  return $image_info->fileId;
}

function get_group_messages($groupId) {
  return  request("GET", "/messages/v4/groups/{$groupId}/messages");
}

function send_group($groupId) {
  return request("POST", "/messages/v4/groups/{$groupId}/send");
}

function delete_messages($groupId, $messageIds = []) {
  if (!is_array($messageIds)) $messageIds = array($messageIds);
  $params = array(
    "messageIds" => $messageIds
  );
  print_r($params);
  return request("DELETE", "/messages/v4/groups/{$groupId}/messages", $params);
}

function send_one_alimtalk($pfId, $templateId, $to, $from, $text, $buttons = []) {
  $kakaoOptions = new stdClass();
  $kakaoOptions->pfId = $pfId;
  $kakaoOptions->templateId = $templateId;
  if (count($buttons) > 0) $kakaoOptions->buttons = $buttons;
  $params = new stdClass();
  $message = new stdClass();
  $message->type = "ATA";
  $message->to = $to;
  $message->from = $from;
  $message->text = $text;
  $message->kakaoOptions = $kakaoOptions;
  $params->message = $message;

  return request("POST", "/messages/v4/send", $params);
}

function send_one_chingutalk($pfId, $to, $from, $text, $buttons = []) {
  $kakaoOptions = new stdClass();
  $kakaoOptions->pfId = $pfId;
  if (count($buttons) > 0) $kakaoOptions->buttons = $buttons;
  $params = new stdClass();
  $message = new stdClass();
  $message->type = "CTA";
  $message->to = $to;
  $message->from = $from;
  $message->text = $text;
  $message->kakaoOptions = $kakaoOptions;
  $params->message = $message;

  return request("POST", "/messages/v4/send", $params);
}

function send_one_message_params($params) {
  return request("POST", "/messages/v4/send", $params);
}

function send_one_message($to, $from, $text, $subject = null, $imageId = null) {
  $params = new stdClass();
  $message = new stdClass();
  $message->text = $text;
  $message->to = $to;
  $message->from = $from;
  if ($subject) $message->subject = $subject;
  if ($imageId) $message->imageId = $imageId;
  $params->message = $message;
  return send_one_message_params($params);
}

function send_messages($messages) {
  $params = array(
    "agent" => array(
      "sdkVersion" => "PHP-SDK v4.0",
      "osPlatform" => PHP_OS . ", PHP Version " . phpversion()
    ),
    "messages" => $messages
  );
  return request("POST", "/messages/v4/send-many", $params);
}

function add_messages($groupId, $messages) {
  $params = array(
    "messages" => $messages
  );
  return add_message_params($groupId, $params);
}

function get_balance() {
  return request("GET", "/cash/v1/balance");
}

function get_messages($params = null) {
  // if (!$params) $params = new stdClass();
  return request("GET", "/messages/v4/list", $params);
}

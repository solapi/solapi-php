<?php
require_once(__DIR__ . "/../config.php");
$config = get_config();

// TODO: PHP SDK version up 되는 경우 해당 값 변경해야 함
$defaultSdkVersion = 'php/4.0.1';
$defaultOsPlatform = PHP_OS . ' | ' . phpversion();

function get_header()
{
    global $config;
    $apiKey = $config["apiKey"];
    $apiSecret = $config["apiSecret"];
    date_default_timezone_set('Asia/Seoul');
    $date = date('Y-m-d\TH:i:s.Z\Z', time());
    $salt = uniqid();
    $signature = hash_hmac('sha256', $date . $salt, $apiSecret);
    return "Authorization: HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
}

function request($method, $resource, $data = false, $headers = null)
{
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
        $http_headers = array(get_header(), "Content-Type: application/json");
        if (is_array($headers)) $http_headers = array_merge($http_headers, $headers);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
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

function create_group_params($params)
{
    return request("POST", "/messages/v4/groups", $params);
}

function create_group()
{
    $params = new stdClass();
    $params->sdkVersion = $GLOBALS['defaultSdkVersion'];
    $params->osPlatform = $GLOBALS['defaultOsPlatform'];
    $result = request("POST", "/messages/v4/groups", $params);
    return $result->groupId;
}

/**
 * @throws Exception
 */
function reserve_group($groupId, $scheduledDate)
{
    if (!$scheduledDate) {
        throw new Exception("예약일시를 입력해야 합니다.");
    } else if (!$groupId) {
        throw new Exception("groupId가 누락되었습니다.");
    }
    $scheduledDate = new DateTime($scheduledDate);

    $params = new stdClass();
    $params->scheduledDate = $scheduledDate->format('c');
    return request("POST", "/messages/v4/groups/" . $groupId . "/schedule", $params);
}

function cancel_reserved_group($groupId)
{
    return request("DELETE", "/messages/v4/groups/" . $groupId . "/schedule");
}

/**
 * @throws Exception
 */
function set_reservation_group_messages($data, $scheduledDate)
{
    $groupId = create_group();
    add_messages($groupId, $data);
    return reserve_group($groupId, $scheduledDate);
}

function get_group_info($groupId)
{
    return request("GET", "/messages/v4/groups/{$groupId}");
}

function get_group_list($limit = 20)
{
    $data = new stdClass();
    $data->limit = $limit;
    return request("GET", "/messages/v4/groups", $data);
}

function delete_group($groupId)
{
    return request("DELETE", "/messages/v4/groups/{$groupId}");
}

function add_message_params($groupId, $params)
{
    return request("PUT", "/messages/v4/groups/{$groupId}/messages", $params);
}

function add_alimtalk($groupId, $pfId, $templateId, $to, $from, $text, $subject = null)
{
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

function add_chingutalk($groupId, $pfId, $to, $from, $text, $subject = null)
{
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

function add_message($groupId, $to, $from, $text, $subject = null, $imageId = null)
{
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

function create_image_params($params)
{
    return request("POST", "/storage/v1/files", $params);
}

// MMS | RCS
function create_image_type($path, $type)
{
    // $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $imageData = base64_encode($data);
    $params = new stdClass();
    $params->type = $type;
    $params->file = $imageData;
    $image_info = create_image_params($params);
    return $image_info->fileId;
}

function create_image($path)
{
    return create_image_type($path, 'MMS');
}

function create_rcs_image($path)
{
    return create_image_type($path, 'RCS');
}

// 친구톡 이미지
function create_kakao_image($path, $link)
{
    // $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $imageData = base64_encode($data);
    $params = new stdClass();
    $params->type = "KAKAO";
    $params->file = $imageData;
    $params->link = $link;
    $image_info = create_image_params($params);
    return $image_info->fileId;
}

function get_group_messages($groupId)
{
    return request("GET", "/messages/v4/groups/{$groupId}/messages");
}

function send_group($groupId)
{
    return request("POST", "/messages/v4/groups/{$groupId}/send");
}

function delete_messages($groupId, $messageIds = array())
{
    if (!is_array($messageIds)) $messageIds = array($messageIds);
    $params = array(
        "messageIds" => $messageIds
    );
    return request("DELETE", "/messages/v4/groups/{$groupId}/messages", $params);
}

function send_one_alimtalk($pfId, $templateId, $to, $from, $text, $buttons = array())
{
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

function send_one_chingutalk($pfId, $to, $from, $text, $buttons = array())
{
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

function send_one_message_params($params)
{
    return request("POST", "/messages/v4/send", $params);
}

function send_one_message($to, $from, $text, $subject = null, $imageId = null)
{
    $params = new stdClass();
    $message = new stdClass();
    $message->text = $text;
    $message->to = $to;
    $message->from = $from;
    if ($subject) $message->subject = $subject;
    if ($imageId) $message->imageId = $imageId;
    $params->agent = array(
        "sdkVersion" => $GLOBALS['defaultSdkVersion'],
        "osPlatform" => $GLOBALS['defaultOsPlatform']
    );
    $params->message = $message;
    return send_one_message_params($params);
}

function send_messages($messages)
{
    $params = array(
        "agent" => array(
            "sdkVersion" => $GLOBALS['defaultSdkVersion'],
            "osPlatform" => $GLOBALS['defaultOsPlatform']
        ),
        "messages" => $messages
    );
    return request("POST", "/messages/v4/send-many", $params);
}

function add_messages($groupId, $messages)
{
    $params = array(
        "messages" => $messages
    );
    return add_message_params($groupId, $params);
}

function get_balance()
{
    return request("GET", "/cash/v1/balance");
}

function get_messages($params = null)
{
    // if (!$params) $params = new stdClass();
    return request("GET", "/messages/v4/list", $params);
}

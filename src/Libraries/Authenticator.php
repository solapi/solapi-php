<?php

namespace Nurigo\Solapi\Libraries;

class Authenticator
{
    /**
     * @param string $apiKey
     * @param string $apiSecretKey
     * @return string
     */
    public static function getAuthorizationHeaderInfo(string $apiKey, string $apiSecretKey): string
    {
        // TODO: Timezone 문제가 생길 수 있어 추후 수정 필요
        date_default_timezone_set("Asia/Seoul");
        $date = date("Y-m-d\TH:i:s.Z\Z", time());
        $salt = uniqid();
        $signature = hash_hmac("sha256", $date . $salt, $apiSecretKey);

        return "Authorization: HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
    }
}
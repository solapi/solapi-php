<?php

namespace Nurigo\Solapi\Libraries;

class Authenticator
{
    /**
     * Authorization 헤더 전체 문자열 반환 (헤더 이름 포함)
     * @param string $apiKey
     * @param string $apiSecretKey
     * @return string "Authorization: HMAC-SHA256 apiKey=..., date=..., salt=..., signature=..."
     * @deprecated Use getAuthorizationHeaderValue() for PSR-7 compatible header value
     */
    public static function getAuthorizationHeaderInfo(string $apiKey, string $apiSecretKey): string
    {
        return "Authorization: " . self::getAuthorizationHeaderValue($apiKey, $apiSecretKey);
    }

    /**
     * Authorization 헤더 값만 반환 (헤더 이름 제외)
     * @param string $apiKey
     * @param string $apiSecretKey
     * @return string "HMAC-SHA256 apiKey=..., date=..., salt=..., signature=..."
     */
    public static function getAuthorizationHeaderValue(string $apiKey, string $apiSecretKey): string
    {
        date_default_timezone_set("Asia/Seoul");
        $date = date("Y-m-d\TH:i:s.Z\Z", time());
        $salt = uniqid();
        $signature = hash_hmac("sha256", $date . $salt, $apiSecretKey);

        return "HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
    }
}
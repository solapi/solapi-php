<?php

namespace Nurigo\Solapi\Libraries;

use Exception;
use Nurigo\Solapi\Exceptions\SolapiCurlException;

class Fetcher
{
    private static $singleton;

    protected $apiKey = '';
    protected $apiSecretKey = '';

    const API_URL = "https://api.solapi.com";

    public static function getInstance(string $apiKey, string $apiSecretKey)
    {
        if (!isset(Fetcher::$singleton)) Fetcher::$singleton = new Fetcher($apiKey, $apiSecretKey);
        return Fetcher::$singleton;
    }

    public function __construct(string $apiKey, string $apiSecretKey)
    {
        $this->apiKey = $apiKey;
        $this->apiSecretKey = $apiSecretKey;
    }

    public function __destruct()
    {
        $this->apiKey = '';
        $this->apiSecretKey = '';
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $data
     * @return mixed
     * @throws Exception|SolapiCurlException CURL 관련된 Exception
     */
    public function request(string $method, string $uri, $data = false)
    {
        $authHeaderInfo = Authenticator::getAuthorizationHeaderInfo($this->apiKey, $this->apiSecretKey);
        $url = self::API_URL . $uri;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        switch ($method) {
            case "POST":
            case "PUT":
            case "DELETE":
                if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "GET":
            default:
                if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
                break;
        }
        $httpHeaders = array($authHeaderInfo, "Content-Type: application/json");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        if (curl_error($curl)) {
            throw new SolapiCurlException(curl_error($curl));
        }
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }
}
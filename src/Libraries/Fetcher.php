<?php

namespace Nurigo\Solapi\Libraries;

use Exception;
use Nurigo\Solapi\Exceptions\BaseException;
use Nurigo\Solapi\Exceptions\CurlException;
use Nurigo\Solapi\Exceptions\UnknownException;
use Nurigo\Solapi\Models\Response\ErrorResponse;

/**
 * @template T, R
 */
class Fetcher
{
    /**
     * @var Fetcher
     */
    private static $singleton;

    protected $apiKey = '';
    protected $apiSecretKey = '';

    const API_URL = "https://api.solapi.com";

    /**
     * @param string $apiKey
     * @param string $apiSecretKey
     * @return Fetcher
     */
    public static function getInstance(string $apiKey, string $apiSecretKey): Fetcher
    {
        if (!isset(Fetcher::$singleton)) Fetcher::$singleton = new Fetcher($apiKey, $apiSecretKey);
        return Fetcher::$singleton;
    }

    /**
     * @param string $apiKey
     * @param string $apiSecretKey
     */
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
     * @throws Exception|CurlException|BaseException|UnknownException CURL 관련된 Exception
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
                if ($data) {
                    $data = NullEliminator::array_null_eliminate((array)$data);
                    $data = json_encode($data);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "GET":
                if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
                break;
        }
        $httpHeaders = array($authHeaderInfo, "Content-Type: application/json");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $jsonResult = json_decode($result);

        if (curl_errno($curl)) {
            throw new CurlException(curl_error($curl));
        }

        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpStatusCode >= 400 && $httpStatusCode <= 500) {
            $errorResponse = new ErrorResponse($jsonResult);
            throw new BaseException($errorResponse->errorMessage, $errorResponse->errorCode);
        } else if ($httpStatusCode != 200) {
            throw new UnknownException("Unknown Http Error Occurred", $result);
        }
        curl_close($curl);

        return $jsonResult;
    }
}
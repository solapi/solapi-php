<?php

namespace Nurigo\Solapi\Libraries;

use Exception;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Uri;
use Nurigo\Solapi\Exceptions\BaseException;
use Nurigo\Solapi\Exceptions\HttpException;
use Nurigo\Solapi\Exceptions\UnknownException;
use Nurigo\Solapi\Models\Response\ErrorResponse;

class Fetcher
{
    private static $singleton;

    protected $apiKey = '';
    protected $apiSecretKey = '';
    protected $httpClient;

    const API_URL = "https://api.solapi.com";
    const DEFAULT_TIMEOUT = 30.0;

    public static function getInstance(string $apiKey, string $apiSecretKey, ?ClientInterface $httpClient = null): Fetcher
    {
        if (!isset(Fetcher::$singleton)) {
            Fetcher::$singleton = new Fetcher($apiKey, $apiSecretKey, $httpClient);
        }
        return Fetcher::$singleton;
    }

    public function __construct(string $apiKey, string $apiSecretKey, ?ClientInterface $httpClient = null)
    {
        $this->apiKey = $apiKey;
        $this->apiSecretKey = $apiSecretKey;
        $this->httpClient = $httpClient ?? new HttpClient([
            'timeout' => self::DEFAULT_TIMEOUT,
            'verify' => true,
        ]);
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
     * @throws Exception|HttpException|BaseException|UnknownException
     */
    public function request(string $method, string $uri, $data = false)
    {
        $authHeaderInfo = Authenticator::getAuthorizationHeaderInfo($this->apiKey, $this->apiSecretKey);
        $headerParts = explode(': ', $authHeaderInfo, 2);
        $authHeaderValue = $headerParts[1] ?? $authHeaderInfo;

        $url = self::API_URL . $uri;
        $body = '';
        $headers = [
            'Authorization' => $authHeaderValue,
            'Content-Type' => 'application/json',
        ];

        try {
            switch ($method) {
                case "POST":
                case "PUT":
                case "DELETE":
                    if ($data) {
                        $data = NullEliminator::array_null_eliminate((array)$data);
                        $body = json_encode($data);
                    }
                    break;
                case "GET":
                    if ($data) {
                        $url .= '?' . http_build_query($data);
                    }
                    break;
            }

            $request = new Request($method, new Uri($url), $headers, $body);
            $response = $this->httpClient->sendRequest($request);

            $httpStatusCode = $response->getStatusCode();
            $responseBody = (string) $response->getBody();
            $jsonResult = json_decode($responseBody);

            if ($httpStatusCode >= 400 && $httpStatusCode <= 500) {
                $errorResponse = new ErrorResponse($jsonResult);
                throw new BaseException($errorResponse->errorMessage, $errorResponse->errorCode);
            } else if ($httpStatusCode != 200) {
                throw new UnknownException("Unknown Http Error Occurred", $responseBody);
            }

            return $jsonResult;

        } catch (ClientExceptionInterface $e) {
            throw new HttpException($e->getMessage(), null, null, $e);
        }
    }
}

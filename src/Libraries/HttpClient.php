<?php

namespace Nurigo\Solapi\Libraries;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;
use Nurigo\Solapi\Exceptions\HttpException;

class HttpClient implements ClientInterface
{
    protected $timeout;
    protected $verifySsl;

    public function __construct(array $options = [])
    {
        $this->timeout = $options['timeout'] ?? 30.0;
        $this->verifySsl = $options['verify'] ?? true;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $method = $request->getMethod();
        $url = (string) $request->getUri();
        $headers = $request->getHeaders();
        $body = (string) $request->getBody();

        $headerLines = [];
        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $headerLines[] = "$name: $value";
            }
        }

        $contextOptions = [
            'http' => [
                'method' => $method,
                'header' => implode("\r\n", $headerLines),
                'timeout' => $this->timeout,
                'ignore_errors' => true,
            ],
        ];

        if ($body !== '') {
            $contextOptions['http']['content'] = $body;
        }

        if (!$this->verifySsl) {
            $contextOptions['ssl'] = [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ];
        } else {
            $contextOptions['ssl'] = [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ];
        }

        $context = stream_context_create($contextOptions);

        // 커스텀 에러 핸들러로 에러 캡처 (@ 연산자 대신)
        $errorMessage = null;
        set_error_handler(function ($severity, $message) use (&$errorMessage) {
            $errorMessage = $message;
            return true; // 기본 에러 핸들러 실행 방지
        });

        $responseBody = file_get_contents($url, false, $context);

        restore_error_handler();

        // $http_response_header는 file_get_contents 호출 후 자동으로 설정됨
        $httpResponseHeader = $http_response_header ?? [];

        if ($responseBody === false) {
            // 에러 메시지에 더 상세한 정보 포함
            $errorDetails = [];
            
            if ($errorMessage !== null) {
                $errorDetails[] = $errorMessage;
            }
            
            // HTTP 응답 헤더가 있으면 상태 정보 추가
            if (!empty($httpResponseHeader)) {
                $statusLine = $httpResponseHeader[0] ?? null;
                if ($statusLine !== null) {
                    $errorDetails[] = "Response: {$statusLine}";
                }
            }
            
            $detailedMessage = !empty($errorDetails) 
                ? implode(' | ', $errorDetails)
                : 'HTTP request failed: ' . $url;

            throw new HttpException($detailedMessage);
        }

        $statusCode = $this->parseStatusCode($httpResponseHeader);
        $reasonPhrase = $this->parseReasonPhrase($httpResponseHeader);
        $responseHeaders = $this->parseHeaders($httpResponseHeader);

        return new Response($statusCode, $responseHeaders, $responseBody, '1.1', $reasonPhrase);
    }

    protected function parseStatusCode(array $headers): int
    {
        if (empty($headers)) {
            return 0;
        }

        foreach ($headers as $header) {
            if (preg_match('/^HTTP\/[\d.]+\s+(\d+)/', $header, $matches)) {
                return (int) $matches[1];
            }
        }

        return 0;
    }

    protected function parseReasonPhrase(array $headers): string
    {
        if (empty($headers)) {
            return '';
        }

        foreach ($headers as $header) {
            if (preg_match('/^HTTP\/[\d.]+\s+\d+\s+(.*)$/', $header, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    protected function parseHeaders(array $rawHeaders): array
    {
        $headers = [];
        foreach ($rawHeaders as $header) {
            if (strpos($header, ':') !== false) {
                list($name, $value) = explode(':', $header, 2);
                $name = trim($name);
                $value = trim($value);
                if (!isset($headers[$name])) {
                    $headers[$name] = [];
                }
                $headers[$name][] = $value;
            }
        }
        return $headers;
    }
}

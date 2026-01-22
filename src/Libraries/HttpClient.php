<?php

namespace Nurigo\Solapi\Libraries;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;
use Nurigo\Solapi\Exceptions\CurlException;

class HttpClient implements ClientInterface
{
    protected $timeout;
    protected $connectTimeout;
    protected $verifySsl;

    public function __construct(array $options = [])
    {
        $this->timeout = $options['timeout'] ?? 30.0;
        $this->connectTimeout = $options['connect_timeout'] ?? 10.0;
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

        $responseBody = @file_get_contents($url, false, $context);

        if ($responseBody === false) {
            $error = error_get_last();
            throw new CurlException(
                $error['message'] ?? 'HTTP request failed: ' . $url,
                null,
                null,
                null
            );
        }

        $statusCode = $this->parseStatusCode($http_response_header ?? []);
        $reasonPhrase = $this->parseReasonPhrase($http_response_header ?? []);
        $responseHeaders = $this->parseHeaders($http_response_header ?? []);

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

<?php

namespace Nurigo\Solapi\Exceptions;

use Exception;
use Throwable;

/**
 * HTTP 요청 중 발생하는 예외
 * 네트워크 오류, 연결 실패, 타임아웃 등
 */
class HttpException extends Exception
{
    /**
     * @var int|null HTTP 상태 코드 (있는 경우)
     */
    protected $statusCode;

    /**
     * @var string|null 응답 본문 (있는 경우)
     */
    protected $responseBody;

    /**
     * @param string $message 에러 메시지
     * @param int|null $statusCode HTTP 상태 코드
     * @param string|null $responseBody 응답 본문
     * @param Throwable|null $previous 이전 예외
     */
    public function __construct(
        string $message = "",
        ?int $statusCode = null,
        ?string $responseBody = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->statusCode = $statusCode;
        $this->responseBody = $responseBody;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @return string|null
     */
    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }
}

<?php

namespace Nurigo\Solapi\Services;

use DateTime;
use Exception;
use Nurigo\Solapi\Exceptions\SolapiCurlException;
use Nurigo\Solapi\Libraries\Fetcher;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Request\SendRequest;

class SolapiMessageService
{
    /**
     * @var Fetcher Fetcher 인스턴스
     */
    private $fetcherInstance;

    public function __construct(string $apiKey, string $apiSecretKey)
    {
        $this->fetcherInstance = Fetcher::getInstance($apiKey, $apiSecretKey);
    }

    /**
     * 메시지 발송
     * @param Message|Message[] $messages
     * @param DateTime|null $scheduledDateTime
     * @throws Exception|SolapiCurlException
     * @return mixed
     */
    public function send($messages, DateTime $scheduledDateTime = null)
    {
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        $requestParameter = new SendRequest($messages, $scheduledDateTime);
        return $this->fetcherInstance->request("POST", "/messages/v4/send-many/detail", $requestParameter);
    }
}
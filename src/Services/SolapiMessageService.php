<?php

namespace Nurigo\Solapi\Services;

use DateTime;
use Exception;
use Nurigo\Solapi\Exceptions\CurlException;
use Nurigo\Solapi\Exceptions\MessageNotReceivedException;
use Nurigo\Solapi\Libraries\Fetcher;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Request\SendRequest;
use stdClass;

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
     * @return stdClass
     * @throws Exception|CurlException|MessageNotReceivedException
     */
    public function send($messages, DateTime $scheduledDateTime = null): stdClass
    {
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        $requestParameter = new SendRequest($messages, $scheduledDateTime);
        $response = $this->fetcherInstance->request("POST", "/messages/v4/send-many/detail", $requestParameter);

        $count = $response->groupInfo->count;
        if (
            (is_array($response->failedMessageList) && count($response->failedMessageList)) &&
            ((int)$count->total === (int)$count->registeredFailed)
        ) {
            throw new MessageNotReceivedException($response->failedMessageList);
        }

        return $response;
    }
}
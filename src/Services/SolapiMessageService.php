<?php

namespace Nurigo\Solapi\Services;

use DateTime;
use Exception;
use Nurigo\Solapi\Exceptions\CurlException;
use Nurigo\Solapi\Exceptions\MessageNotReceivedException;
use Nurigo\Solapi\Libraries\Fetcher;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Request\SendRequest;
use Nurigo\Solapi\Models\Response\SendResponse;

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
     * @return SendResponse
     * @throws Exception|CurlException|MessageNotReceivedException
     */
    public function send($messages, DateTime $scheduledDateTime = null): SendResponse
    {
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        $requestParameter = new SendRequest($messages, $scheduledDateTime);
        $result = $this->fetcherInstance->request("POST", "/messages/v4/send-many/detail", $requestParameter);
        $response = new SendResponse($result);

        /*$count = $response->groupInfo->count;
        if (
            count($response->failedMessageList) > 0 &&
            ($count->total === $count->registeredFailed)
        ) {
            throw new MessageNotReceivedException($response->failedMessageList);
        }*/

        return $response;
    }

    public function uploadFile(string $filePath, $type = "MMS")
    {
        $fileContent = file_get_contents($filePath);
        $encodedFile = base64_encode($fileContent);
    }
}
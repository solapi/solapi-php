<?php

namespace Nurigo\Solapi\Services;

use DateTime;
use Exception;
use Nurigo\Solapi\Exceptions\CurlException;
use Nurigo\Solapi\Exceptions\MessageNotReceivedException;
use Nurigo\Solapi\Libraries\Fetcher;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Request\SendRequest;
use Nurigo\Solapi\Models\Request\UploadFileRequest;
use Nurigo\Solapi\Models\Response\SendResponse;
use Nurigo\Solapi\Models\Response\UploadFileResponse;

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

        $count = $response->groupInfo->count;
        if (
            count($response->failedMessageList) > 0 &&
            ($count->total === $count->registeredFailed)
        ) {
            throw new MessageNotReceivedException($response->failedMessageList);
        }

        return $response;
    }

    /**
     * @param string $filePath 파일 경로
     * @param string $type 파일 유형(MMS, RCS, DOCUMENT, KAKAO)
     * @return string|null
     */
    public function uploadFile(string $filePath, string $type = "MMS", $name = null, $link = null)
    {
        $fileContent = file_get_contents($filePath);
        $encodedFile = base64_encode($fileContent);

        $parameter = new UploadFileRequest();
        $parameter->setFile($encodedFile)
            ->setType($type);

        if ($name !== null && $name !== '') {
            $parameter->setName($name);
        }

        if ($link !== null && $link !== '') {
            $parameter->setLink($link);
        }

        try {
            $result = $this->fetcherInstance->request("POST", "/storage/v1/files", $parameter);
            if (isset($result->errorCode)) {
                throw new Exception();
            }
            $response = new UploadFileResponse($result);
            return $response->fileId;
        } catch (Exception $exception) {
            return null;
        }
    }
}
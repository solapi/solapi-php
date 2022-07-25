<?php

namespace Nurigo\Solapi\Models\Response;

class UploadFileResponse
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $originalName;

    /**
     * @var string
     */
    public $link;

    /**
     * @var string
     */
    public $fileId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $accountId;

    /**
     * @var string
     */
    public $dateCreated;

    /**
     * @var string
     */
    public $dateUpdated;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->type = $value->type;
        $this->originalName = $value->originalName;
        $this->link = $value->link;
        $this->fileId = $value->fileId;
        $this->name = $value->name;
        $this->url = $value->url;
        $this->accountId = $value->accountId;
        $this->dateCreated = $value->dateCreated;
        $this->dateUpdated = $value->dateUpdated;
    }
}
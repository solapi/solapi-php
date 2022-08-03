<?php

namespace Nurigo\Solapi\Models\Request;

class UploadFileRequest
{
    /**
     * @var string base64 encode된 문자
     */
    public $file;

    /**
     * @var string file 유형(MMS, KAKAO 등)
     */
    public $type;

    /**
     * @var string|null 파일 이름
     */
    public $name;

    /**
     * @var string|null 첨부파일 링크(친구톡 이미지 전용)
     */
    public $link;

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return UploadFileRequest
     */
    public function setFile(string $file): UploadFileRequest
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return UploadFileRequest
     */
    public function setType(string $type): UploadFileRequest
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UploadFileRequest
     */
    public function setName(string $name): UploadFileRequest
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return UploadFileRequest
     */
    public function setLink(string $link): UploadFileRequest
    {
        $this->link = $link;
        return $this;
    }

    public function __construct()
    {
        unset($this->name);
        unset($this->link);
    }
}
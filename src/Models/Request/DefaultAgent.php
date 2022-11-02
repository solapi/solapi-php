<?php

namespace Nurigo\Solapi\Models\Request;

class DefaultAgent
{
    /**
     * @var string PHP SDK 버전
     */
    public $sdkVersion;

    /**
     * @var string SDK 사용자 OS 버전
     */
    public $osPlatform;

    public function __construct()
    {
        $this->sdkVersion = 'php/5.0.4';
        $this->osPlatform = PHP_OS . " | " . phpversion();
    }
}
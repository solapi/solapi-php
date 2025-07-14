<?php

namespace Nurigo\Solapi\Models\Kakao;

class KakaoBms {
    /**
     * @var string M, N, I 값만 허용됩니다, M, N 값은 카카오 측에 별도 인허가를 받은 비즈니스 채널만 이용하실 수 있습니다.
     * M: 마케팅 수신 동의자 + 카카오 비즈니스 채널 친구 대상으로 발송
     * N: 마케팅 수신 동의자에게만 발송
     * I: 카카오 비즈니스 채널 친구에게만 발송
     */
    public $targeting;

    /**
     * @return string
     */
    public function getTargeting(): string
    {
        return $this->targeting;
    }

    /**
     * @param string $targeting
     */
    public function setTargeting(string $targeting): KakaoBms
    {
        $this->targeting = $targeting;
        return $this;
    }


}
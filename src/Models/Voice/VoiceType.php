<?php

namespace Nurigo\Solapi\Models\Voice;

class VoiceType {
    public const FEMALE = 'FEMALE';
    public const MALE = 'MALE';

    public static function values(): array {
        return [
            self::FEMALE,
            self::MALE,
        ];
    }
}

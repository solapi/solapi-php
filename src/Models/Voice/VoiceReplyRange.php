<?php

namespace Nurigo\Solapi\Models\Voice;

class VoiceReplyRange {
    public const ONE = 1;
    public const TWO = 2;
    public const THREE = 3;
    public const FOUR = 4;
    public const FIVE = 5;
    public const SIX = 6;
    public const SEVEN = 7;
    public const EIGHT = 8;
    public const NINE = 9;

    public static function values(): array {
        return [
            self::ONE,
            self::TWO,
            self::THREE,
            self::FOUR,
            self::FIVE,
            self::SIX,
            self::SEVEN,
            self::EIGHT,
            self::NINE,
        ];
    }
}

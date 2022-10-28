<?php

namespace Nurigo\Solapi\Libraries;

class NullEliminator
{
    static function array_null_eliminate(array $data): array
    {
        $result = array();
        foreach ($data as $key => $value) {
            $tempValue = null;
            if (is_array($value) || is_object($value)) {
                $tempValue = self::array_null_eliminate((array)$value);
            } else if (!is_null($value)) {
                $tempValue = $value;
            }
            if (!is_null($tempValue)) {
                $result[$key] = $tempValue;
            }
        }
        return $result;
    }
}
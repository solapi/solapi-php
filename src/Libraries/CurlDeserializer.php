<?php

namespace Nurigo\Solapi\Libraries;

use ReflectionObject;
use stdClass;

trait CurlDeserializer
{
    static function deserialize(stdClass $object): self
    {
        $deserializedClass = new self();
        $reflectedObject = new ReflectionObject($object);
        $properties = $reflectedObject->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            if (gettype($deserializedClass->{$name}) == "object") {
                self::deserialize($deserializedClass->{$name});
            } else {
                $deserializedClass->{$name} = $object->$name;
            }
        }
        return $deserializedClass;
    }
}
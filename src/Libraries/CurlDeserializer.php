<?php

namespace Nurigo\Solapi\Libraries;

use ReflectionObject;
use stdClass;

trait CurlDeserializer
{
    static function deserialize(stdClass $object): self
    {
        $deserializedClass = new self();
        $reflectionObject = new ReflectionObject($object);
        $reflectionProperties = $reflectionObject->getProperties();
        foreach ($reflectionProperties as $reflectionProperty) {
            $name = $reflectionProperty->getName();
            if (property_exists(self::class, $name)) {
                $deserializedClass->{$name} = $object->$name;
            }
        }
        unset($object);
        return $deserializedClass;
    }
}
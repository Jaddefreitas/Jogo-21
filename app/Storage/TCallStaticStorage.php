<?php

namespace App\Storage;

use SplObjectStorage;
use BadMethodCallException;

/**
 * Permite chamar estaticamente o storage, tratando-o como um singleton
 */
trait TCallStaticStorage
{
    public static SplObjectStorage $storage;

    public static function __callStatic(string $name, array $arguments)
    {
        if (!isset(static::$storage)) {
            static::$storage = new SplObjectStorage();
        }

        $storage = static::$storage;

        if (!method_exists($storage, $name)) {
            throw new BadMethodCallException("Call to undefined method $name()");
        }

        return $storage->$name(...$arguments);
    }
}
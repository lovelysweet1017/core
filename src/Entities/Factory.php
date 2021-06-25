<?php


namespace Longman\TelegramBot\Entities;


abstract class Factory
{
    abstract public function make(array $data, string $bot_username): Entity;

    public static function resolveEntityClass(string $class, array $property, string $bot_username = ''): Entity
    {
        if (is_subclass_of($class, Factory::class)) {
            return $class->make($property, $bot_username);
        }

        return new $class($property, $bot_username);
    }
}

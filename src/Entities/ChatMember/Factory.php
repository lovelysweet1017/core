<?php


namespace Longman\TelegramBot\Entities\ChatMember;


use Longman\TelegramBot\Entities\Entity;
use Longman\TelegramBot\Exception\TelegramException;

class Factory extends \Longman\TelegramBot\Entities\Factory
{
    public function make(array $data, string $bot_username): Entity
    {
        if (! isset($data['status'])) {
            throw new TelegramException('Missing ChatMember status');
        }

        $type = [
            'creator'       => ChatMemberOwner::class,
            'administrator' => ChatMemberAdministrator::class,
            'member'        => ChatMemberMember::class,
            'restricted'    => ChatMemberRestricted::class,
            'left'          => ChatMemberLeft::class,
            'kicked'        => ChatMemberBanned::class,
        ];

        if (! isset($type[$data['status']])) {
            throw new TelegramException('Unexpected ChatMember status');
        }

        $class = $type[$data['status']];
        return new $class($data, $bot_username);
    }
}

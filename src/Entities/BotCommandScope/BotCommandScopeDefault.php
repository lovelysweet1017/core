<?php


namespace Longman\TelegramBot\Entities\BotCommandScope;


use Longman\TelegramBot\Entities\Entity;
use Longman\TelegramBot\Entities\InputMedia\InputMediaAnimation;

/**
 * Class BotCommandScopeDefault
 *
 * @link https://core.telegram.org/bots/api#botcommandscopedefault
 */
class BotCommandScopeDefault extends Entity implements BotCommandScope
{
    public function __construct(array $data = [])
    {
        $data['type'] = 'default';
        parent::__construct($data);
    }
}

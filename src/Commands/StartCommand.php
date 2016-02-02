<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands;

use Longman\TelegramBot\Command;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class StartCommand extends Command
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'start';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Start command';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '/';

    /**
     * Version
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * If this command is enabled
     *
     * @var boolean
     */
    protected $enabled = true;

    /**
     * If this command is public
     *
     * @var boolean
     */
    protected $public = false;

    /**
     * Execute command
     *
     * @return boolean
     */
    public function execute()
    {
        $update = $this->getUpdate();
        $message = $this->getMessage();

        $chat_id = $message->getChat()->getId();
        $data = array();
        $data['chat_id'] = $chat_id;

        $text = "Hi there!\nType /help to see all commands!";

        $data['text'] = $text;
        $result = Request::sendMessage($data);
        return $result->isOk();
    }
}

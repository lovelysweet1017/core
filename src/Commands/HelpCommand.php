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

class HelpCommand extends Command
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'help';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Show bot commands help';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '/help or /help <command>';

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
    protected $public = true;

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
        $message_id = $message->getMessageId();
        $text = $message->getText(true);

        $commands = $this->telegram->getCommandsList();

        if (empty($text)) {
            $msg = $this->telegram->getBotName() . ' v. ' . $this->telegram->getVersion() . "\n\n";
            $msg .= 'Commands List:' . "\n";
            foreach ($commands as $command) {
                if (is_object($command)) {
                    if (!$command->isEnabled()) {
                        continue;
                    }
                    if (!$command->isPublic()) {
                        continue;
                    }

                    $msg .= '/' . $command->getName() . ' - ' . $command->getDescription() . "\n";
                }
            }

            $msg .= "\n" . 'For exact command help type: /help <command>';
        } else {
            $text = str_replace('/', '', $text);
            if (isset($commands[$text])) {
                $command = $commands[$text];
                if (!$command->isEnabled() || !$command->isPublic()) {
                    $msg = 'Command ' . $text . ' not found';
                } else {
                    $msg = 'Command: ' . $command->getName() . ' v' . $command->getVersion() . "\n";
                    $msg .= 'Description: ' . $command->getDescription() . "\n";
                    $msg .= 'Usage: ' . $command->getUsage();
                }
            } else {
                $msg = 'Command ' . $text . ' not found';
            }
        }

        $data = [];
        $data['chat_id'] = $chat_id;
        $data['reply_to_message_id'] = $message_id;
        $data['text'] = $msg;

        $result = Request::sendMessage($data);
        return $result->isOk();
    }
}

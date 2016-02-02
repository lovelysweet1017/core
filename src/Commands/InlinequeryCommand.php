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
use Longman\TelegramBot\Entities\Entity;
use Longman\TelegramBot\Entities\InlineQueryResultArticle;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class InlinequeryCommand extends Command
{
    /**
     * Name
     *
     * @var string
     */
    protected $name = 'inlinequery';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Reply to inline query';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = '';

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
        $inline_query = $update->getInlineQuery();
        $query = $inline_query->getQuery();

        $data = [];
        $data['inline_query_id']= $inline_query->getId();

        $articles = [];
        $articles[] = ['id' => '001' , 'title' => 'https://core.telegram.org/bots/api#answerinlinequery', 'message_text' => 'you enter: '.$query ];
        $articles[] = ['id' => '002' , 'title' => 'https://core.telegram.org/bots/api#answerinlinequery', 'message_text' => 'you enter: '.$query ];
        $articles[] = ['id' => '003' , 'title' => 'https://core.telegram.org/bots/api#answerinlinequery', 'message_text' => 'you enter: '.$query ];

        $array_article = [];
        foreach ($articles as $article) {
            $array_article[] = new InlineQueryResultArticle($article);
        }
        $array_json = '['.implode(',', $array_article).']';
        $data['results'] = $array_json;

        $result = Request::answerInlineQuery($data);

        return $result->isOk();
    }
}

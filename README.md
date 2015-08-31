# PHP Telegram Bot
======================

[![Join the chat at https://gitter.im/akalongman/php-telegram-bot](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/akalongman/php-telegram-bot?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/akalongman/php-telegram-bot.svg?branch=master)](https://travis-ci.org/akalongman/php-telegram-bot)
[![Latest Stable Version](https://img.shields.io/packagist/v/Longman/telegram-bot.svg)](https://packagist.org/packages/longman/telegram-bot)
[![Total Downloads](https://img.shields.io/packagist/dt/Longman/telegram-bot.svg)](https://packagist.org/packages/longman/telegram-bot)
[![Downloads Month](https://img.shields.io/packagist/dm/Longman/telegram-bot.svg)](https://packagist.org/packages/longman/telegram-bot)
[![License](https://img.shields.io/packagist/l/Longman/telegram-bot.svg)](https://packagist.org/packages/longman/telegram-bot)


A Telegram Bot based on the official [Telegram Bot API](https://core.telegram.org/bots/api)


## introduction
This is a pure php Telegram Bot, fully extensible via plugins. Telegram recently announced official support for a [Bot API](https://telegram.org/blog/bot-revolution) allowing integrators of all sorts to bring automated interactions to the mobile platform. This Bot aims to provide a platform where one could simply write a plugin and have interactions in a matter of minutes.
The Bot supports Reply Markup and handle commands in group chat with multiple bot.


Instructions
============

1. Message @botfather https://telegram.me/botfather with the following text: `/newbot`
   If you don't know how to message by username, click the search field on your Telegram app and type `@botfather`, you should be able to initiate a conversation. Be careful not to send it to the wrong contact, because some users has similar usernames to `botfather`.

   ![botfather initial conversation](http://i.imgur.com/aI26ixR.png)

2. @botfather replies with `Alright, a new bot. How are we going to call it? Please choose a name for your bot.`

3. Type whatever name you want for your bot.

4. @botfather replies with `Good. Now let's choose a username for your bot. It must end in `bot`. Like this, for example: TetrisBot or tetris_bot.`

5. Type whatever username you want for your bot, minimum 5 characters, and must end with `bot`. For example: `telesample_bot`

6. @botfather replies with:

    Done! Congratulations on your new bot. You will find it at telegram.me/telesample_bot. You can now add a description, about section and profile picture for your bot, see /help for a list of commands.

    Use this token to access the HTTP API:
    <b>123456789:AAG90e14-0f8-40183D-18491dDE</b>

    For a description of the Bot API, see this page: https://core.telegram.org/bots/api

7. Note down the 'token' mentioned above.

8. Type `/setprivacy` to @botfather.

   ![botfather later conversation](http://i.imgur.com/tWDVvh4.png)

9. @botfather replies with `Choose a bot to change group messages settings.`

10. Type `@telesample_bot` (change to the username you set at step 5 above, but start it with `@`)

11. @botfather replies with

    'Enable' - your bot will only receive messages that either start with the '/' symbol or mention the bot by username.
    'Disable' - your bot will receive all messages that people send to groups.
    Current status is: ENABLED

12. Type `Disable` to let your bot receive all messages sent to a group. This step is up to you actually.

13. @botfather replies with `Success! The new status is: DISABLED. /help`




## Installation
You need server with https and composer support.

Install this package through [Composer](https://getcomposer.org/). Edit your project's `composer.json` file to require `longman/telegram-bot`.

Create composer.json file:
```js
{
    "name": "yourproject/yourproject",
    "type": "project",
    "require": {
        "php": ">=5.4.0",
        "longman/telegram-bot": "*"
    }
}
```
And run composer update

**Or** run a command in your command line:

```
composer require longman/telegram-bot
```

###### bot token
You will notice that the Telegram Bot wants a value for `API_KEY`. This token may be obtained via a telegram client for your bot. See [this](https://core.telegram.org/bots#botfather) link if you are unsure of how to so this.


## Usage
You must set [WebHook](https://core.telegram.org/bots/api#setwebhook)

Create set.php and put:
```php
<?php

$loader = require __DIR__.'/vendor/autoload.php';

$API_KEY = 'your_bot_api_key';
$BOT_NAME = 'namebot';

try {
    // create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($API_KEY, $BOT_NAME);

    // set webhook
    echo $telegram->setWebHook('https://yourdomain/yourpath_to_hook.php');
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
```
And open your set.php via browser


After create hook.php and put:
```php
<?php

$loader = require __DIR__.'/vendor/autoload.php';

$API_KEY = 'your_bot_api_key';
$BOT_NAME = 'namebot';

try {
    // create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($API_KEY,$BOT_NAME);

    // here you can set some command specified parameters, for example, google geocode/timezone api key for date command:
    $telegram->setCommandConfig('date', array('google_api_key'=>'your_google_api_key_here'));

    // handle telegram webhook request
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}
```

If you want insert in database messages/users for further usage in commands, create database and import structure.sql and enable mysql support after object creation and BEFORE handle method

```php
<?php

$credentials = array('host'=>'localhost', 'user'=>'dbuser', 'password'=>'dbpass', 'database'=>'dbname');

$telegram->enableMySQL($credentials);

```
You can set a custom prefix to all the tables while you are enabling mysql:

```php
$telegram->enableMySQL($credentials, $BOT_NAME.'_');

```

Commads
--------------
The bot is able to recognise commands in chat with multiple bot.
It can execute command triggering a chat event. Here's the list:

-Groupchatcreated (GroupchatcreatedCommand.php)
-Newchatparticipant (NewchatparticipantCommand.php)
-Deletechatphoto (DeletechatphotoCommand.php)
-Newchattitle (NewchattitleCommand.php)
-Leftchatparticipant (LeftchatparticipantCommand.php)

GenericCommand.php let you handle commands that non exist or use commands as var:  
Favourite colour? /black /red 
Favourite number? /1 /134 


Maybe you would like to develop your own commands. A good practice is to store them outside vendor/. This can be done adding before the method:

```php
$COMMANDS_FOLDER = __DIR__.'/Commands/';
$telegram->addCommandsPath($COMMANDS_FOLDER);

```



Send message to all active chats (new!)
---------------------------------------
To do this you have to enable the mysql connections.
Here's an example of use:

```php
$results = $telegram->sendToActiveChats(
        'sendMessage', //callback function to execute (see Request.php methods)
        array('text'=>'Hey! Checkout the new feature!!'), //Param to evaluate the request
        true, //Send to chats (group chat)
        true, //Send to users (single chat)
        null, //'yyyy-mm-dd hh:mm:ss' date range from
        null  //'yyyy-mm-dd hh:mm:ss' date range to
    );

print_r($results);
```

Utilis
------
You can also log incoming messages on a text file, set this option with the methods:
```php
$telegram->setLogRequests(true);
$telegram->setLogPath($BOT_NAME.'.log');

```

This code is available on [Github][0]. Pull requests are welcome.


Troubleshooting
-------------

If you like living on the edge, please report any bugs you find on the [PHP Telegram Bot issues](https://github.com/akalongman/php-telegram-bot/issues) page.


Contributing
-------------

See [CONTRIBUTING.md](CONTRIBUTING.md) for information.


## Credits

Created by [Avtandil Kikabidze][1].

[0]: https://github.com/akalongman/php-telegram-bot
[1]: mailto:akalongman@gmail.com

<?php

/*
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace Longman\TelegramBot\Entities;

use Longman\TelegramBot\Exception\TelegramException;

class Contact extends Entity
{

    protected $phone_number;
    protected $first_name;
    protected $last_name;
    protected $user_id;

    public function __construct(array $data)
    {

        $this->phone_number = isset($data['phone_number']) ? $data['phone_number'] : null;
        if (empty($this->phone_number)) {
            throw new TelegramException('phone_number is empty!');
        }

        $this->first_name = isset($data['first_name']) ? $data['first_name'] : null;
        if (empty($this->first_name)) {
            throw new TelegramException('first_name is empty!');
        }

        $this->last_name = isset($data['last_name']) ? $data['last_name'] : null;
        $this->user_id = isset($data['user_id']) ? $data['user_id'] : null;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}

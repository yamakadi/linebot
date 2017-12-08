<?php

namespace Yamakadi\LineBot\Events;

class Unfollow extends Generic implements Event
{
    const TYPE = 'unfollow';

    /**
     * @param array $data  Data as returned by the LINE Messaging API
     * @return \Yamakadi\LineBot\Events\Unfollow
     */
    public static function make(array $data): Unfollow
    {
        return new static($data['timestamp'], $data['source']);
    }
}
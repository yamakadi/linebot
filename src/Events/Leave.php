<?php

namespace Yamakadi\LineBot\Events;

class Leave extends Generic implements Event
{
    const TYPE = 'leave';

    /**
     * @param array $data  Data as returned by the LINE Messaging API
     * @return \Yamakadi\LineBot\Events\Leave
     */
    public static function make(array $data): Leave
    {
        return new static($data['timestamp'], $data['source']);
    }
}
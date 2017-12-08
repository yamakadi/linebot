<?php

namespace Yamakadi\LineBot\Messages\Incoming;

use Yamakadi\LineBot\Events\Message;

class Location extends Message
{
    const TYPE = 'location';

    public function address(): string
    {
        return $this->message['address'];
    }

    public function title(): string
    {
        return $this->message['title'];
    }

    public function latitude(): float
    {
        return $this->message['latitude'];
    }

    public function longitude(): float
    {
        return $this->message['longitude'];
    }
}
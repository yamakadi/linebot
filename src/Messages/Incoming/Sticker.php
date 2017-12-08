<?php

namespace Yamakadi\LineBot\Messages\Incoming;

use Yamakadi\LineBot\Events\Message;

class Sticker extends Message
{
    const TYPE = 'sticker';

    public function package(): string
    {
        return $this->message['packageId'];
    }

    public function sticker(): string
    {
        return $this->message['stickerId'];
    }
}
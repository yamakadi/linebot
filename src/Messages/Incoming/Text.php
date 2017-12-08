<?php

namespace Yamakadi\LineBot\Messages\Incoming;

use Yamakadi\LineBot\Events\Message;

class Text extends Message
{
    const TYPE = 'text';

    public function text(): string
    {
        return $this->message['text'];
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Incoming;

use Yamakadi\LineBot\Events\Message;

class File extends Message
{
    const TYPE = 'file';

    public function name(): string
    {
        return $this->message['fileName'];
    }

    public function size(): int
    {
        return (int) $this->message['fileSize'];
    }
}
<?php

namespace Yamakadi\LineBot\Messages;

use JsonSerializable;

abstract class OutgoingMessage implements JsonSerializable
{
    abstract public function toArray(): array;

    /**
     * {@inheritdoc}
     */
    function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
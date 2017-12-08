<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class MessageCollection extends OutgoingMessage
{
    const TYPE = 'collection';

    /** @var \Yamakadi\LineBot\Messages\OutgoingMessage[] */
    protected $messages = [];

    /**
     * You can use a Message Collection if you'd like to
     * send more than one message at once.
     *
     * @param \Yamakadi\LineBot\Messages\OutgoingMessage[] $messages
     */
    public function __construct(OutgoingMessage ...$messages)
    {
        $this->push(...$messages);
    }

    public static function make(OutgoingMessage ...$messages)
    {
        return new static(...$messages);
    }

    public function messages()
    {
        return $this->messages();
    }

    public function push(OutgoingMessage ...$messages): self
    {
        if ($messages && $this->canAddMoreMessages($messages)) {
            $this->messages = array_merge($this->messages, $messages);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->messages;
    }

    private function canAddMoreMessages(array $messages)
    {
        $currentMessageCount = count($this->messages);
        $messageCount = count($messages);

        if ($currentMessageCount > 5 || $messageCount > 5 || $currentMessageCount + $messageCount > 5) {
            throw new InvalidArgumentException('You can only send 5 messages at once.');
        }

        return true;
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use Yamakadi\LineBot\Messages\OutgoingMessage;

class Text extends OutgoingMessage
{
    const TYPE = 'text';

    /** @var string */
    protected $text;

    /**
     * Create a new Text Instance.
     *
     * Any extra text given will be attached to the main text with an
     * EOL. Please create a new text object if you want a new message.
     *
     * @param string   $text
     * @param string[] $extraText
     */
    public function __construct(string $text, string ...$extraText)
    {
        $this->text = implode(PHP_EOL, array_merge(
            [$text], $extraText
        ));
    }

    public static function make(string $text): self
    {
        return new static($text);
    }

    public function text(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'text' => $this->text,
        ];
    }
}
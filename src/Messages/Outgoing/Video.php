<?php

namespace Yamakadi\LineBot\Messages\Outgoing;


use Yamakadi\LineBot\Messages\OutgoingMessage;

class Video extends OutgoingMessage
{
    const TYPE = 'video';

    /**
     * @var string
     */
    protected $original;
    /**
     * @var string
     */
    protected $preview;

    /**
     * Create a new Video Instance
     *
     * @param string $original
     * @param string $preview
     */
    public function __construct(string $original, string $preview)
    {
        $this->original = $original;
        $this->preview = $preview;
    }

    public static function make(string $original, string $preview): self
    {
        return new static($original, $preview);
    }

    public function original(): string
    {
        return $this->original;
    }

    public function preview(): string
    {
        return $this->preview;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'originalContentUrl' => $this->original,
            'previewImageUrl' => $this->preview,
        ];
    }
}
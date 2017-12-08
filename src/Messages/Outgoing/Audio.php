<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use Yamakadi\LineBot\Messages\OutgoingMessage;

class Audio extends OutgoingMessage
{
    const TYPE = 'audio';

    /**
     * @var string
     */
    protected $original;

    /**
     * @var int
     */
    protected $duration;

    /**
     * Create a new Video Instance
     *
     * @param string $original
     * @param int    $duration
     */
    public function __construct(string $original, int $duration)
    {
        $this->original = $original;
        $this->duration = $duration;
    }

    public static function make(string $original, int $duration): self
    {
        return new static($original, $duration);
    }

    public function original(): string
    {
        return $this->original;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'originalContentUrl' => $this->original,
            'duration' => $this->duration,
        ];
    }
}
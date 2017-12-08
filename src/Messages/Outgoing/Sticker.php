<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use Yamakadi\LineBot\Messages\OutgoingMessage;

class Sticker extends OutgoingMessage
{
    const TYPE = 'sticker';

    /**
     * @var string
     */
    protected $package;
    /**
     * @var string
     */
    protected $sticker;

    /**
     * Create a new Sticker Instance
     *
     * @param string $package
     * @param string $sticker
     */
    public function __construct(string $package, string $sticker)
    {
        $this->package = $package;
        $this->sticker = $sticker;
    }

    public static function make(string $package, string $sticker): self
    {
        return new static($package, $sticker);
    }

    public function package(): string
    {
        return $this->package;
    }

    public function sticker(): string
    {
        return $this->sticker;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'packageId' => $this->package,
            'stickerId' => $this->sticker,
        ];
    }
}
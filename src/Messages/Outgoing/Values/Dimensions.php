<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Values;

use JsonSerializable;

class Dimensions implements JsonSerializable
{
    /** @var int */
    private $height;

    /** @var int */
    private $width;

    /**
     * Create a new Dimensions Instance
     *
     * @param int $height
     * @param int $width
     */
    public function __construct(int $height, int $width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function height(): int
    {
        return $this->width;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function toArray(): array
    {
        return [
            'height' => $this->height,
            'width' => $this->width,
        ];
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }
}
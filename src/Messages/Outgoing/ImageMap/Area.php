<?php

namespace Yamakadi\LineBot\Messages\Outgoing\ImageMap;

use JsonSerializable;
use Yamakadi\LineBot\Messages\Outgoing\Values\Position;
use Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions;

class Area implements JsonSerializable
{
    /** @var \Yamakadi\LineBot\Messages\Outgoing\Values\Position */
    private $position;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions */
    private $dimensions;

    /**
     * Create a new Area Instance
     *
     * @param \Yamakadi\LineBot\Messages\Outgoing\Values\Position   $position
     * @param \Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions $dimensions
     */
    public function __construct(Position $position, Dimensions $dimensions)
    {
        $this->position = $position;
        $this->dimensions = $dimensions;
    }

    public function toArray(): array
    {
        return [
            'x' => $this->position->x(),
            'y' => $this->position->y(),
            'width' => $this->dimensions->width(),
            'height' => $this->dimensions->height(),
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
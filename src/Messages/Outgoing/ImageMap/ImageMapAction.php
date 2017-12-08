<?php

namespace Yamakadi\LineBot\Messages\Outgoing\ImageMap;

use JsonSerializable;

abstract class ImageMapAction implements JsonSerializable
{
    /** @var \Yamakadi\LineBot\Messages\Outgoing\ImageMap\Area */
    public $area;

    public function area(): Area
    {
        return $this->area;
    }

    abstract public function toArray(): array;

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

use JsonSerializable;

abstract class TemplateAction implements JsonSerializable
{
    /** @var string */
    public $label;

    public function label(): string
    {
        return $this->label;
    }

    public function withLabel(string $label): self
    {
        $this->label = $label;

        return $this;
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
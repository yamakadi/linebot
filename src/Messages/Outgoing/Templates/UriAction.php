<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

class UriAction extends TemplateAction
{
    const TYPE = 'uri';

    /** @var string */
    protected $uri;

    /**
     * Create a new UriAction Instance
     *
     * @param string $uri
     * @param string $label
     */
    public function __construct(string $label, string $uri)
    {
        $this->uri = $uri;
        $this->label = $label;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'label' => $this->label,
            'uri' => $this->uri
        ];
    }
}
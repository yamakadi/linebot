<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

class PostbackAction extends TemplateAction
{
    const TYPE = 'postback';

    /** @var string */
    protected $data;

    /** @var string */
    protected $text;

    /**
     * Create a new PostbackAction Instance
     *
     * @param string $label
     * @param string $data
     */
    public function __construct(string $label, string $data)
    {
        $this->label = $label;
        $this->data = $data;
    }

    public function withText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function toArray(): array
    {
        $action = [
            'type' => self::TYPE,
            'label' => $this->label,
            'data' => $this->data,
            'text' => $this->text
        ];

        return array_filter($action);
    }
}
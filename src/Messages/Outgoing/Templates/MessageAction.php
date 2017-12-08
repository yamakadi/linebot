<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

class MessageAction extends TemplateAction
{
    const TYPE = 'message';

    /** @var string */
    protected $text;

    /**
     * Create a new MessageAction Instance
     *
     * @param string $text
     * @param string $label
     */
    public function __construct(string $label, string $text)
    {
        $this->text = $text;
        $this->label = $label;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'label' => $this->label,
            'text' => $this->text
        ];
    }
}
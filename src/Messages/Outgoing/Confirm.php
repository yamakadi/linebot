<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use TypeError;
use Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class Confirm extends OutgoingMessage
{
    const TYPE = 'confirm';

    /** @var string */
    private $altText;

    /** @var string */
    private $text;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] */
    private $actions;

    /**
     * Create a new Buttons Instance
     *
     * @param string                                                       $altText
     * @param string                                                       $text
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction $yes
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction $no
     */
    public function __construct(string $altText, string $text, TemplateAction $yes, TemplateAction $no)
    {
        $this->altText = $altText;
        $this->text = $text;
        $this->actions = [$yes, $no];
    }

    public function toArray(): array
    {
        return [
            'type' => 'template',
            'altText' => $this->altText,
            'template' => [
                'type' => self::TYPE,
                'text' => $this->text,
                'actions' => $this->actions,
            ],
        ];
    }
}
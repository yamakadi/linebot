<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

use InvalidArgumentException;
use JsonSerializable;

class ImageCarouselColumn implements JsonSerializable
{
    /** @var string */
    private $url;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] */
    private $actions = [];

    /**
     * Create a new ImageCarouselColumn Instance
     *
     * @param string                                                         $url
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] $actions
     */
    public function __construct(string $url, TemplateAction ...$actions)
    {
        $this->url = $url;
        $this->withAction(...$actions);
    }

    public static function make(string $url): self
    {
        return new static($url);
    }

    public function withAction(TemplateAction ...$actions): self
    {
        if ($this->canAddMoreActions($actions)) {
            $this->actions = array_merge($this->actions, $actions);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'imageUrl' => $this->url,
            'actions' => $this->actions,
        ];
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    private function canAddMoreActions($actions)
    {
        $currentActionCount = count($this->actions);
        $actionCount = count($actions);

        if ($currentActionCount > 3 || $actionCount > 3 || $currentActionCount + $actionCount > 3) {
            throw new InvalidArgumentException('You can add 4 actions at most.');
        }

        return true;
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing\Templates;

use InvalidArgumentException;
use JsonSerializable;

class CarouselColumn implements JsonSerializable
{
    /** @var string */
    protected $thumbnail;

    /** @var string */
    protected $backgroundColor;

    /** @var string */
    protected $title;

    /** @var string */
    private $text;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] */
    private $actions = [];

    /**
     * Create a new CarouselColumn Instance
     *
     * @param string                                                         $text
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] $actions
     */
    public function __construct(string $text, TemplateAction ...$actions)
    {
        $this->text = $text;
        $this->withAction(...$actions);
    }

    public static function make(string $text): self
    {
        return new static($text);
    }

    public function withAction(TemplateAction ...$actions): self
    {
        if ($this->canAddMoreActions($actions)) {
            $this->actions = array_merge($this->actions, $actions);
        }

        return $this;
    }

    public function withThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function withBackgroundColor(string $color = '#ffffff'): self
    {
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/i', $color)) {
            throw new InvalidArgumentException('Background color of the image must be a hex color value');
        }

        $this->backgroundColor = $color;

        return $this;
    }

    public function withTitle(string $title): self
    {
        if (strlen($title) > 40) {
            throw new InvalidArgumentException('Title cannot be longer than 40 characters');
        }

        $this->title = $title;

        return $this;
    }

    public function toArray(): array
    {
        $template = [
            'thumbnailImageUrl' => $this->thumbnail,
            'imageBackgroundColor' => $this->backgroundColor,
            'title' => $this->title,
            'text' => $this->text,
            'actions' => $this->actions,
        ];

        return array_filter($template);
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
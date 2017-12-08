<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use TypeError;
use Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class Buttons extends OutgoingMessage
{
    const TYPE = 'buttons';

    /** @var string */
    protected $thumbnail;

    /** @var string */
    protected $aspectRatio;

    /** @var string */
    protected $imageSize;

    /** @var string */
    protected $backgroundColor;

    /** @var string */
    protected $title;

    /** @var string */
    private $altText;

    /** @var string */
    private $text;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] */
    private $actions;

    /**
     * Create a new Buttons Instance
     *
     * @param string                                                         $altText
     * @param string                                                         $text
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\TemplateAction[] $actions
     * @throws \TypeError
     */
    public function __construct(string $altText, string $text, TemplateAction ...$actions)
    {
        $this->altText = $altText;
        $this->text = $text;
        $this->withAction(...$actions);
    }

    public static function make(string $altText, string $text): self
    {
        return new static($altText, $text);
    }

    public function withAction(TemplateAction ...$actions): self
    {
        if($this->canAddMoreActions($actions)) {
            $this->actions = array_merge($this->actions, $actions);
        }

        return $this;
    }

    public function withThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function withAspectRatio(string $ratio = 'rectangle'): self
    {
        if (!in_array($ratio, ['square', 'rectangle'])) {
            throw new InvalidArgumentException('Aspect ratio of the image can only be "rectangle" or "square"');
        }

        $this->aspectRatio = $ratio;

        return $this;
    }

    public function withImageSize(string $size = 'cover'): self
    {
        if (!in_array($size, ['cover', 'contain'])) {
            throw new InvalidArgumentException('Size of the image can only be "cover" or "contain"');
        }

        $this->imageSize = $size;

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
            'type' => 'template',
            'altText' => $this->altText,
            'template' => [
                'type' => self::TYPE,
                'thumbnailImageUrl' => $this->thumbnail,
                'imageAspectRatio' => $this->aspectRatio,
                'imageSize' => $this->imageSize,
                'imageBackgroundColor' => $this->backgroundColor,
                'title' => $this->title,
                'text' => $this->text,
                'actions' => $this->actions,
            ],
        ];

        return array_filter($template);
    }

    private function canAddMoreActions(array $actions)
    {
        $currentActionCount = count($this->actions);
        $actionCount = count($actions);

        if ($currentActionCount > 4 || $actionCount > 4 || $currentActionCount + $actionCount > 4) {
            throw new InvalidArgumentException('You can add 4 actions at most.');
        }

        return true;
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use Yamakadi\LineBot\Messages\Outgoing\Templates\CarouselColumn;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class Carousel extends OutgoingMessage
{
    const TYPE = 'carousel';

    /** @var string */
    private $altText;

    /** @var string */
    protected $aspectRatio;

    /** @var string */
    protected $imageSize;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\CarouselColumn[] */
    private $columns;

    /**
     * Create a new Carousel Instance
     *
     * @param string                                                         $altText
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\CarouselColumn[] $columns
     * @throws \TypeError
     */
    public function __construct(string $altText, CarouselColumn ...$columns)
    {
        $this->altText = $altText;
        $this->withColumns(...$columns);
    }

    public static function make(string $altText, string $text): self
    {
        return new static($altText, $text);
    }

    public function withColumns(CarouselColumn ...$columns): self
    {
        if ($this->canAddMoreColumns($columns)) {
            $this->columns = array_merge($this->columns, $columns);
        }

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

    public function toArray(): array
    {
        $template = [
            'type' => 'template',
            'altText' => $this->altText,
            'template' => [
                'type' => self::TYPE,
                'imageAspectRatio' => $this->aspectRatio,
                'imageSize' => $this->imageSize,
                'columns' => $this->columns,
            ],
        ];

        return array_filter($template);
    }

    private function canAddMoreColumns(array $columns)
    {
        $currentColumnCount = count($this->columns);
        $columnCount = count($columns);

        if ($currentColumnCount > 10 || $columnCount > 10 || $currentColumnCount + $columnCount > 10) {
            throw new InvalidArgumentException('You can add 10 columns at most.');
        }

        return true;
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use Yamakadi\LineBot\Messages\Outgoing\Templates\ImageCarouselColumn;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class ImageCarousel extends OutgoingMessage
{
    const TYPE = 'image_carousel';

    /** @var string */
    private $altText;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Templates\ImageCarouselColumn[] */
    private $columns = [];

    /**
     * Create a new ImageCarousel Instance
     *
     * @param string                                                              $altText
     * @param \Yamakadi\LineBot\Messages\Outgoing\Templates\ImageCarouselColumn[] $columns
     */
    public function __construct(string $altText, ImageCarouselColumn ...$columns)
    {
        $this->altText = $altText;
        $this->withColumns(...$columns);
    }

    public static function make(string $altText): self
    {
        return new static($altText);
    }

    public function withColumns(ImageCarouselColumn ...$columns): self
    {
        if ($this->canAddMoreColumns($columns)) {
            $this->columns = array_merge($this->columns, $columns);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => 'template',
            'altText' => $this->altText,
            'template' => [
                'type' => self::TYPE,
                'columns' => $this->columns,
            ],
        ];
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
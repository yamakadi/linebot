<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use InvalidArgumentException;
use Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions;
use Yamakadi\LineBot\Messages\Outgoing\ImageMap\ImageMapAction;
use Yamakadi\LineBot\Messages\OutgoingMessage;

class ImageMap extends OutgoingMessage
{
    const TYPE = 'imagemap';

    /** @var int[] */
    private $allowedImageDimensions = [240, 300, 460, 700, 1040];

    /** @var string */
    private $altText;

    /** @var string */
    private $uri;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions */
    private $size;

    /** @var \Yamakadi\LineBot\Messages\Outgoing\ImageMap\ImageMapAction[] */
    private $actions = [];

    /**
     * Create a new ImageMap Instance
     *
     * @param string                                                      $altText
     * @param string                                                      $uri
     * @param \Yamakadi\LineBot\Messages\Outgoing\Values\Dimensions       $size
     * @param \Yamakadi\LineBot\Messages\Outgoing\ImageMap\ImageMapAction[] $actions
     */
    public function __construct(string $altText, string $uri, Dimensions $size, ImageMapAction ...$actions)
    {
        $this->sizeValid($size);

        $this->altText = $altText;
        $this->uri = $uri;
        $this->size = $size;
        $this->actions = $actions;
    }

    public function withAction(ImageMapAction $action): self
    {
        $this->actions[] = $action;

        return $this;
    }

    protected function sizeValid(Dimensions $size): bool
    {
        if (
            !in_array($size->width(), $this->allowedImageDimensions, true)
            || !in_array($size->height(), $this->allowedImageDimensions, true)
        ) {
            throw new InvalidArgumentException('Image dimensions must be within limits set by LINE.');
        }

        return true;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'baseUrl' => $this->uri,
            'altText' => $this->altText,
            'baseSize' => $this->size->toArray(),
            'actions' => $this->actions
        ];
    }
}
<?php

namespace Yamakadi\LineBot\Messages\Outgoing\ImageMap;

class MessageAction extends ImageMapAction
{
    const TYPE = 'message';

    /** @var string */
    private $text;

    /**
     * Create a new MessageAction Instance
     *
     * @param string                                            $text
     * @param \Yamakadi\LineBot\Messages\Outgoing\ImageMap\Area $area
     */
    public function __construct(string $text, Area $area)
    {
        $this->area = $area;
        $this->text = $text;
    }

    public static function make(string $text, Area $area): self
    {
        return new static($text, $area);
    }

    public function text(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'text' => $this->text,
            'area' => $this->area
        ];
    }
}
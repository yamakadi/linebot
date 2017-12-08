<?php

namespace Yamakadi\LineBot\Messages\Outgoing\ImageMap;

class UriAction extends ImageMapAction
{
    const TYPE = 'uri';

    /** @var string */
    private $uri;

    /**
     * Create a new MessageAction Instance
     *
     * @param string                                            $uri
     * @param \Yamakadi\LineBot\Messages\Outgoing\ImageMap\Area $area
     */
    public function __construct(string $uri, Area $area)
    {
        $this->area = $area;
        $this->uri = $uri;
    }

    public static function make(string $uri, Area $area): self
    {
        return new static($uri, $area);
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'linkUri' => $this->uri,
            'area' => $this->area
        ];
    }}
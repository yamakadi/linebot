<?php

namespace Yamakadi\LineBot\Messages\Outgoing;

use Yamakadi\LineBot\Messages\OutgoingMessage;

class Location extends OutgoingMessage
{
    const TYPE = 'location';

    /** @var string */
    private $address;

    /** @var string */
    private $title;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * Create a new Location instance
     *
     * @param string $address
     * @param string $title
     * @param float  $latitude
     * @param float  $longitude
     */
    public function __construct(string $address, string $title, float $latitude, float $longitude)
    {
        $this->address = $address;
        $this->title = $title;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public static function make(string $address, string $title, float $latitude, float $longitude): self
    {
        return new static($address, $title, $latitude, $longitude);
    }

    public function address(): string
    {
        return $this->address;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'title' => $this->title,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
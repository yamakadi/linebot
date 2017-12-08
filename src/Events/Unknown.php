<?php

namespace Yamakadi\LineBot\Events;

class Unknown extends Generic
{
    /** @var array */
    protected $raw;

    /**
     * Create a new Unknown Instance
     *
     * @param int   $timestamp
     * @param array $source
     * @param array $raw
     */
    public function __construct(int $timestamp, array $source, array $raw)
    {
        parent::__construct($timestamp, $source);

        $this->raw = $raw;
    }

    public static function make($data): Unknown
    {
        return new static($data['timestamp'], $data['source'], $data);
    }

    public function raw(): array
    {
        return $this->raw;
    }
}
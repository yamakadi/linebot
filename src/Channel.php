<?php

namespace Yamakadi\LineBot;

class Channel
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $secret;

    /**
     * Create a new Channel Instance
     *
     * @param string $id
     * @param string $secret
     */
    public function __construct(string $id, string $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function secret(): string
    {
        return $this->secret;
    }
}
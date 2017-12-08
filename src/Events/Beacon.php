<?php

namespace Yamakadi\LineBot\Events;

class Beacon extends Generic implements Event, CanBeReplied
{
    const TYPE = 'beacon';

    /** @var array */
    private $beacon;

    /** @var string */
    protected $replyToken;

    /**
     * Create a new Follow Instance
     *
     * @param int    $timestamp
     * @param array  $source
     * @param string $replyToken
     * @param array  $beacon
     */
    public function __construct(int $timestamp, array $source, string $replyToken, array $beacon)
    {
        parent::__construct($timestamp, $source);

        $this->replyToken = $replyToken;
        $this->beacon = $beacon;
    }

    /**
     * @param array $data Data as returned by the LINE Messaging API
     * @return \Yamakadi\LineBot\Events\Beacon
     */
    public static function make(array $data): Beacon
    {
        return new static($data['timestamp'], $data['source'], $data['replyToken'], $data['beacon']);
    }

    public function beacon(): array
    {
        return $this->beacon;
    }

    public function event(): string
    {
        return $this->beacon['type'];
    }

    public function hwid(): string
    {
        return $this->beacon['hwid'];
    }

    public function deviceMessage(): string
    {
        return pack('H*', $this->beacon['dm']);
    }

    public function replyToken(): string
    {
        return $this->replyToken;
    }
}
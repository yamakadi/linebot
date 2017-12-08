<?php

namespace Yamakadi\LineBot\Events;

class Join extends Generic implements Event, CanBeReplied
{
    const TYPE = 'join';

    /** @var string */
    protected $replyToken;

    /**
     * Create a new Follow Instance
     *
     * @param int    $timestamp
     * @param array  $source
     * @param string $replyToken
     */
    public function __construct(int $timestamp, array $source, string $replyToken)
    {
        parent::__construct($timestamp, $source);

        $this->replyToken = $replyToken;
    }

    /**
     * @param array $data  Data as returned by the LINE Messaging API
     * @return \Yamakadi\LineBot\Events\Join
     */
    public static function make(array $data): Join
    {
        return new static($data['timestamp'], $data['source'], $data['replyToken']);
    }

    public function replyToken(): string
    {
        return $this->replyToken;
    }
}
<?php

namespace Yamakadi\LineBot\Events;

class Follow extends Generic implements Event, CanBeReplied
{
    const TYPE = 'follow';

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
     * @return \Yamakadi\LineBot\Events\Follow
     */
    public static function make(array $data): Follow
    {
        return new static($data['timestamp'], $data['source'], $data['replyToken']);
    }

    public function replyToken(): string
    {
        return $this->replyToken;
    }
}
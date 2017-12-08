<?php

namespace Yamakadi\LineBot\Events;

class Message extends Generic implements Event, CanBeReplied
{
    const TYPE = 'message';

    /** @var string */
    protected $replyToken;

    /** @var array */
    protected $message;

    /**
     * Create a new Follow Instance
     *
     * @param int    $timestamp
     * @param array  $source
     * @param string $replyToken
     * @param array  $message
     */
    public function __construct(int $timestamp, array $source, string $replyToken, array $message)
    {
        parent::__construct($timestamp, $source);

        $this->replyToken = $replyToken;
        $this->message = $message;
    }

    /**
     * @param array $data  Data as returned by the LINE Messaging API
     * @return static
     */
    public static function make(array $data)
    {
        return new static($data['timestamp'], $data['source'], $data['replyToken'], $data['message']);
    }

    /**
     * Message id
     *
     * @return string
     */
    public function id(): string
    {
        return $this->message['id'];
    }

    public function replyToken(): string
    {
        return $this->replyToken;
    }
}
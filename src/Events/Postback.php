<?php

namespace Yamakadi\LineBot\Events;

use DateTimeImmutable;
use DateTimeZone;

class Postback extends Generic implements Event, CanBeReplied
{
    const TYPE = 'postback';

    /** @var string */
    protected $data;

    /** @var array */
    protected $params;

    /** @var string */
    protected $replyToken;

    /**
     * Event object for when a user performs an action on a template message
     * which initiates a postback. You can reply to postback events.
     *
     * @param int    $timestamp
     * @param array  $source
     * @param string $replyToken
     * @param array  $postback
     */
    public function __construct(int $timestamp, array $source, string $replyToken, array $postback)
    {
        parent::__construct($timestamp, $source);

        $this->replyToken = $replyToken;

        $this->data = $postback['data'];
        $this->params = $postback['params'] ?? [];
    }

    /**
     * @param array $data Data as returned by the LINE Messaging API
     * @return \Yamakadi\LineBot\Events\Postback
     */
    public static function make(array $data): Postback
    {
        return new static($data['timestamp'], $data['source'], $data['replyToken'], $data['postback']);
    }

    public function data(): string
    {
        return $this->data;
    }

    /**
     * An array with the date and time selected by a user through a datetime picker action.
     * Only returned for postback actions via the datetime picker.
     *
     * array['date']      array  Date selected by user. Only included in the date mode.
     *      ['time']      array  Time selected by the user. Only included in the time mode.
     *      ['datetime']  array  Date and time selected by the user. Only included in the datetime mode.
     *
     * @return array
     */
    public function params(): array
    {
        return $this->params;
    }

    /**
     * @param \DateTimeZone|null $timezone
     * @return \DateTimeImmutable|null
     */
    public function date(?DateTimeZone $timezone = null): ?DateTimeImmutable
    {
        if(array_key_exists('time', $this->params)) {
            return DateTimeImmutable::createFromFormat(
                'H:i', $this->params['time'], $timezone ?? new DateTimeZone('Asia/Tokyo')
            );
        }

        if(array_key_exists('date', $this->params)) {
            return DateTimeImmutable::createFromFormat(
                'Y-m-d\TH:i', $this->params['date'] . 'T00:00', $timezone ?? new DateTimeZone('Asia/Tokyo')
            );
        }

        if(array_key_exists('datetime', $this->params)) {
            return DateTimeImmutable::createFromFormat(
                'Y-m-d\TH:i', $this->params['datetime'], $timezone ?? new DateTimeZone('Asia/Tokyo')
            );
        }

        return null;
    }

    public function replyToken(): string
    {
        return $this->replyToken;
    }
}
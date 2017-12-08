<?php

namespace Yamakadi\LineBot\Events;

use DateTimeImmutable;
use DateTimeZone;
use Yamakadi\LineBot\Exceptions\UnknownEventSourceException;

abstract class Generic implements Event
{
    /** @var DateTimeImmutable */
    protected $timestamp;

    /**  @var array */
    protected $source;

    /**
     * Create a new Follow Instance
     *
     * @param int   $timestamp
     * @param array $source
     */
    public function __construct(int $timestamp, array $source)
    {
        $this->source = $source;

        $this->timestamp = DateTimeImmutable::createFromFormat('U.u', (float)$timestamp / 1000)
            ->setTimezone(new DateTimeZone('Asia/Tokyo'));
    }

    public function type(): string
    {
        return self::TYPE;
    }

    public function timestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function source(): array
    {
        return $this->source;
    }

    public function sourceId(): string
    {
        switch ($this->source['type']) {
            case 'user':
                return $this->source['userId'];
            case 'group':
                return $this->source['groupId'];
            case 'room':
                return $this->source['roomId'];
            default:
                throw new UnknownEventSourceException;
        }
    }

    public function sourceUser(): ?string
    {
        return $this->source['userId'] ?? null;
    }
}
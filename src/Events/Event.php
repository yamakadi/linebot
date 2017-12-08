<?php

namespace Yamakadi\LineBot\Events;

use DateTimeImmutable;

interface Event
{
    public function type(): string;
    public function timestamp(): DateTimeImmutable;
    public function source(): array;
    public function sourceId(): string;
}
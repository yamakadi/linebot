<?php

namespace Yamakadi\LineBot\Events;

interface CanBeReplied
{
    public function replyToken(): string;
}
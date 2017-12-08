<?php

namespace Yamakadi\LineBot\Exceptions;

use Exception;

class UnknownEventSourceException extends Exception
{
    /**
     * Create a new UnknownEventException Instance
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        parent::__construct(
            $message ?? ''
        );
    }

}
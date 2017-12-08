<?php

namespace Yamakadi\LineBot\Exceptions;

use GuzzleHttp\Exception\ClientException;

class InvalidRequestException extends \RuntimeException
{
    public static function fromClientException(ClientException $e)
    {
        $response = $e->getResponse();
        $responseContents = json_decode($response->getBody()->getContents(), true);

        return new static($responseContents['error_description'], $response->getStatusCode());
    }
}
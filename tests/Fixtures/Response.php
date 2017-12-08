<?php

namespace Yamakadi\LineBot\Fixtures;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    public static function issueAccessToken()
    {
        return new GuzzleResponse(200, [], '{"access_token":"valid_token", "expires_in":2592000, "token_type":"Bearer"}');
    }
}
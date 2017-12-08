<?php

namespace Yamakadi\LineBot\AccessToken;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Yamakadi\LineBot\Exceptions\InvalidRequestException;

class Revoke
{
    const ENDPOINT = 'https://api.line.me/v2/oauth/revoke';

    /** @var \GuzzleHttp\ClientInterface */
    private $http;

    /**
     * Create a new Issue Instance
     *
     * @param \GuzzleHttp\ClientInterface $http
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * Revokes a channel access token.
     *
     * @param \Yamakadi\LineBot\AccessToken\Token $token
     * @return bool  Returns true if the token has been revoked successfully
     * @throws \Yamakadi\LineBot\Exceptions\InvalidRequestException
     */
    public function revokeToken(Token $token): bool
    {
        try {
            $this->http->request('POST', self::ENDPOINT, [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                RequestOptions::FORM_PARAMS => [
                    'access_token' => (string) $token,
                ],
            ]);

            return true;

        } catch (ClientException $e) {
            throw InvalidRequestException::fromClientException($e);
        }
    }

    /**
     * Revokes a channel access token.
     *
     * @param \Yamakadi\LineBot\AccessToken\Token $token
     * @return bool  Returns true if the token has been revoked successfully
     * @throws \Yamakadi\LineBot\Exceptions\InvalidRequestException
     */
    public function __invoke(Token $token): bool
    {
        return $this->revokeToken($token);
    }

}
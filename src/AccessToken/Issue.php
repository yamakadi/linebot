<?php

namespace Yamakadi\LineBot\AccessToken;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Yamakadi\LineBot\Exceptions\InvalidRequestException;

class Issue
{
    const ENDPOINT = 'https://api.line.me/v2/oauth/accessToken';

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
     * Issues a short-lived channel access token.
     * Up to 30 tokens can be issued. If the maximum is exceeded, existing channel
     * access tokens will be revoked in the order of when they were first issued.
     *
     * @param string $channelId
     * @param string $channelSecret
     * @return \Yamakadi\LineBot\AccessToken\Token
     * @throws \Yamakadi\LineBot\Exceptions\InvalidRequestException
     */
    public function issueToken(string $channelId, string $channelSecret): Token
    {
        try {
            $response = $this->http->request('POST', self::ENDPOINT, [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $channelId,
                    'client_secret' => $channelSecret
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return Token::makeShortLived($data['access_token'], (int) $data['expires_in']);

        } catch (ClientException $e) {
            throw InvalidRequestException::fromClientException($e);
        }
    }

    /**
     * Issues a short-lived channel access token.
     * Up to 30 tokens can be issued. If the maximum is exceeded, existing channel
     * access tokens will be revoked in the order of when they were first issued.
     *
     * @param string $channelId
     * @param string $channelSecret
     * @return \Yamakadi\LineBot\AccessToken\Token
     * @throws \Yamakadi\LineBot\Exceptions\InvalidRequestException
     */
    public function __invoke(string $channelId, string $channelSecret): Token
    {
        return $this->issueToken($channelId, $channelSecret);
    }

}
<?php

namespace Yamakadi\LineBot;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Yamakadi\LineBot\AccessToken\Token;
use Yamakadi\LineBot\Events\Message;
use Yamakadi\LineBot\Events\Unknown;
use Yamakadi\LineBot\Exceptions\InvalidRequestException;
use Yamakadi\LineBot\Exceptions\InvalidSignatureException;
use Yamakadi\LineBot\Messages\OutgoingMessage;
use Yamakadi\LineBot\Users\User;

class LineBot
{
    use VerifiesSignature;

    const LINE_SIGNATURE = 'X_LINE_SIGNATURE';
    const API_ENDPOINT = 'https://api.line.me';
    const VERSION = '1.0';

    /** @var \Yamakadi\LineBot\Channel */
    private $channel;

    /** @var \Yamakadi\LineBot\AccessToken\Token */
    private $token;

    /** @var \GuzzleHttp\ClientInterface */
    private $http;

    /** @var array */
    private $headers;

    /** @var array */
    private $namespaces = [
        'event' => 'Yamakadi\LineBot\Events\%s',
        'message' => 'Yamakadi\LineBot\Messages\Incoming\%s',
    ];

    /**
     * Create a new LineBot Instance
     *
     * @param \Yamakadi\LineBot\Channel           $channel
     * @param \Yamakadi\LineBot\AccessToken\Token $token
     * @param \GuzzleHttp\ClientInterface         $http
     */
    public function __construct(Channel $channel, Token $token, ClientInterface $http)
    {
        $this->channel = $channel;
        $this->token = $token;
        $this->http = $http;

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$token}",
            'User-Agent' => 'Yamakadi-LineBot/1.0',
        ];
    }

    /**
     * @param string $payload
     * @param string $signature
     * @return \Yamakadi\LineBot\Events\Event[]
     *
     * @throws \Yamakadi\LineBot\Exceptions\InvalidRequestException
     * @throws \Yamakadi\LineBot\Exceptions\InvalidSignatureException
     */
    public function parse(string $payload, string $signature)
    {
        if (!$this->verifySignature($this->channel->secret(), $signature, $payload)) {
            throw new InvalidSignatureException('The signature is not valid.');
        }

        $payload = json_decode($payload, true);

        if (!array_key_exists('events', $payload)) {
            throw new InvalidRequestException;
        }

        return array_map(function ($event) {
            $class = $this->determineClassname('event', $event['type']);

            if (!class_exists($class)) {
                return Unknown::make($event);
            }

            $instance = $class::make($event);

            if ($instance instanceof Message) {
                $messageClass = $this->determineClassname('message', $event['message']['type']);

                if (class_exists($messageClass)) {
                    return $messageClass::make($event);
                }
            }

            return $instance;

        }, $payload['events']);
    }

    /**
     * Gets message content which is associated with specified message ID.
     *
     * @param string $messageId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function content(string $messageId): ResponseInterface
    {
        return $this->http->request(
            'GET', self::API_ENDPOINT . '/v2/bot/message/' . urlencode($messageId) . '/content', [
            RequestOptions::HEADERS => $this->headers,
        ]);
    }

    /**
     * Gets specified user's profile through API calling.
     *
     * @param string      $userId
     * @param string|null $groupOrRoomId
     * @return \Yamakadi\LineBot\Users\User
     */
    public function profile(string $userId, ?string $groupOrRoomId = null): User
    {
        $endpoint = $groupOrRoomId
            ? sprintf(
                '%s/v2/bot/%s/%s/member/%s',
                self::API_ENDPOINT,
                $this->determineType($groupOrRoomId),
                urlencode($groupOrRoomId),
                urlencode($userId)
            )
            : sprintf(
                '%s/v2/bot/profile/%s',
                self::API_ENDPOINT,
                urlencode($userId)
            );

        $response = $this->http->request('GET', $endpoint, [
            RequestOptions::HEADERS => $this->headers,
        ]);

        return User::create(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Replies arbitrary message to destination which is associated with reply token.
     *
     * @param string          $token
     * @param OutgoingMessage $messages
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reply(string $token, OutgoingMessage $messages): ResponseInterface
    {
        return $this->http->request('POST', self::API_ENDPOINT . '/v2/bot/message/reply', [
            RequestOptions::JSON => [
                'replyToken' => $token,
                'messages' => $messages,
            ],
            RequestOptions::HEADERS => $this->headers,
        ]);
    }

    /**
     * Sends arbitrary messages to destination.
     *
     * @param string|string[] $to
     * @param OutgoingMessage $messages
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send($to, OutgoingMessage $messages): ResponseInterface
    {
        $endpoint = is_array($to)
            ? self::API_ENDPOINT . '/v2/bot/message/multicast'
            : self::API_ENDPOINT . '/v2/bot/message/push';

        return $this->http->request('POST', $endpoint, [
            RequestOptions::JSON => [
                'to' => $to,
                'messages' => $messages,
            ],
            RequestOptions::HEADERS => $this->headers,
        ]);
    }

    /**
     * Gets the user IDs of the members of a group or room that the bot is in.
     * This includes the user IDs of users who have not added the bot as a friend or has blocked the bot.
     *
     * This feature is only available for LINE@ Approved accounts or official accounts.
     *
     * @param string $id
     * @param string $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function participants(string $id, string $next = ''): ResponseInterface
    {
        $type = $this->determineType($id);

        return $this->http->request(
            'GET', self::API_ENDPOINT . '/v2/bot/' . $type . '/' . $id . '/members/ids?start=' . $next, [
            RequestOptions::HEADERS => $this->headers,
        ]);
    }

    /**
     * Gets the user IDs of all the members of a group or room that the bot is in.
     * This includes the user IDs of users who have not added the bot as a friend or has blocked the bot.
     *
     * This feature is only available for LINE@ Approved accounts or official accounts.
     *
     * @param string $id
     * @return array
     */
    public function allParticipants(string $id): array
    {
        $participants = [];
        $next = null;

        do {
            $response = $this->participants($id);
            $data = json_decode($response->getBody()->getContents(), true);
            $participants = array_merge($participants, $data['memberIds']);

            $next = $data['next'] ?? null;

        } while ($next);

        return $participants;
    }

    /**
     * Leaves from group or room
     *
     * @param string $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function leave(string $id): ResponseInterface
    {
        $type = $this->determineType($id);

        return $this->http->request('POST', self::API_ENDPOINT . '/v2/bot/' . $type . '/' . urlencode($id) . '/leave', [
            RequestOptions::HEADERS => $this->headers,
        ]);
    }

    /**
     * Determines whether a given ID belongs to a group, room, or user.
     *
     * @param string $id
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function determineType(string $id): string
    {
        $types = [
            'C' => 'group',
            'R' => 'room',
            'U' => 'user',
        ];

        $typeIdentifier = substr($id, 0, 1);

        if (!array_key_exists($typeIdentifier, $types)) {
            throw new InvalidArgumentException('The given ID does not match any LINE ID type');
        }

        return $types[$typeIdentifier];
    }

    protected function determineClassname(string $namespace, string $type): string
    {
        if (!array_key_exists($namespace, $this->namespaces)) {
            throw new InvalidArgumentException('Undefined namespace');
        }

        return sprintf($this->namespaces[$namespace], ucfirst($type));
    }
}

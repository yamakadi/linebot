<?php

namespace Yamakadi\LineBot\AccessToken;

use DateInterval;
use DateTimeImmutable;

class Token
{
    /** @var \DateTimeImmutable */
    private $expiresIn;

    /** @var string */
    private $token;

    /**
     * Create a new AccessToken Instance
     *
     * @param string $token
     * @param int    $expiresIn
     */
    public function __construct(string $token, int $expiresIn)
    {
        $this->token = $token;

        $this->expiresIn = (new DateTimeImmutable())->add(new DateInterval(
            $expiresIn ? "PT{$expiresIn}S"  : 'P1Y'
        ));;
    }

    public static function make(string $token): Token
    {
        return new static($token, 0);
    }

    public static function makeShortLived(string $token, int $expiresIn): Token
    {
        return new static($token, $expiresIn);
    }

    /**
     * Channel Access Token
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }

    /**
     * Seconds until the token expires
     *
     * @return \DateTimeImmutable
     */
    public function expiresIn(): DateTimeImmutable
    {
        return $this->expiresIn;
    }

    public function __toString(): string
    {
        return $this->token;
    }

}
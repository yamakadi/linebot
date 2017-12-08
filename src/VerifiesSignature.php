<?php

namespace Yamakadi\LineBot;

trait VerifiesSignature
{
    /**
     * Check whether the request signature is valid
     *
     * @param string $channelSecret
     * @param string $signature
     * @param string $payload
     * @return bool
     */
    public function verifySignature(string $channelSecret, string $signature, string $payload): bool
    {
        return hash_equals(
            base64_encode(hash_hmac('sha256', $payload, $channelSecret, true)), $signature
        );
    }
}
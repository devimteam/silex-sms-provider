<?php

namespace Devim\Provider\SmsServiceProvider;

class NullService implements SmsServiceInterface
{
    public function send(string $phone, string $text, string $shortCode = null) : array
    {
        return [];
    }

    public function check(string $transactionId, string $phone = null) : array
    {
        return [];
    }

    public function receive() : array
    {
        return [];
    }
}
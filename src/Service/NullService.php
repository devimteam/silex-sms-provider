<?php

namespace Devim\Provider\SmsServiceProvider\Service;

class NullService implements SmsServiceInterface
{
    public function send(string $phone, string $text, string $shortCode = null)
    {
        return '1';
    }

    public function check(string $transactionId, string $phone = null)
    {
        return;
    }

    public function receive()
    {
        return;
    }
}
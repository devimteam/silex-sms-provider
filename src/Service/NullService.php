<?php

namespace Devim\Provider\SmsServiceProvider;

class NullService implements ServiceInterface
{
    public function send(string $phone, string $text, string $shortCode)
    {

    }

    public function check()
    {

    }

    public function receive()
    {

    }
}
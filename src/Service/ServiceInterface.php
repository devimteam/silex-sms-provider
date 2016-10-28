<?php

namespace Devim\Provider\SmsServiceProvider;

interface ServiceInterface
{
    public function send(string $phone, string $text, string $shortCode);
}
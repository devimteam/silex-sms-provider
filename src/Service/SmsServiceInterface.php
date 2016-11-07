<?php

namespace Devim\Provider\SmsServiceProvider;

interface SmsServiceInterface
{
    /**
     * @param string $phone
     * @param string $text
     * @param string|null $shortCode
     *
     * @return mixed
     */
    public function send(string $phone, string $text, string $shortCode = null);

    /**
     * @param string $transactionId
     * @param string|null $phone
     *
     * @return mixed
     */
    public function check(string $transactionId, string $phone = null);

    /**
     * @return mixed
     */
    public function receive();
}
<?php

namespace Devim\Provider\SmsServiceProvider\Exception;

class SmsSendException extends \Exception
{
    public function __construct($status)
    {
        parent::__construct(sprintf('Error. SMS service answered with status "%s"', $status));
    }
}
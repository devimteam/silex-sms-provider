<?php

namespace Devim\Provider\SmsServiceProvider\Exception;

class SmsErrorException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
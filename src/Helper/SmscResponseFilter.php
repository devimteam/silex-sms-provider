<?php

namespace Devim\Provider\SmsServiceProvider\Helper;

use Devim\Provider\SmsServiceProvider\Exception\SmsErrorException;

class SmscResponseFilter
{
    /**
     * @param array $response
     *
     * @return array
     *
     * @throws SmsErrorException
     */
    public static function filter(array $response)
    {
        if (array_key_exists('error', $response)) {
            throw new SmsErrorException($response['error']);
        } else {
            return $response;
        }
    }
}
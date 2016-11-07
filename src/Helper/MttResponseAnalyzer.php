<?php

namespace Devim\Provider\SmsServiceProvider\Helper;

use Devim\Provider\SmsServiceProvider\Exception\SmsErrorException;

class MttResponseAnalyzer
{
    const SMS_STATUS_DELIVERED = 0;
    const SMS_STATUS_EXPIRED = 1;
    const SMS_STATUS_UNDELIVERABLE = 2;
    const SMS_STATUS_REJECTED = 3;

    const RESPONSES = [
        'delivered' => self::SMS_STATUS_DELIVERED,
        'expired' => self::SMS_STATUS_EXPIRED,
        'undeliverable' => self::SMS_STATUS_UNDELIVERABLE,
        'rejected' => self::SMS_STATUS_REJECTED
    ];

    const ERRORS = [
        'system error',
        'login/password is incorrect',
        'not supported operation',
        'invalid ID',
        'invalid MSISDN',
        'invalid shortcode',
        'billing failed',
        'throttling error',
        'transaction not found'
    ];

    /**
     * @param string $response
     *
     * @return string|int
     *
     * @throws SmsErrorException
     */
    public static function check(string $response)
    {
        if (array_search($response, self::ERRORS)) {
            throw new SmsErrorException($response);
        }

        if (is_numeric($response)) {
            return $response;
        } else {
            return self::RESPONSES[$response];
        }
    }
}
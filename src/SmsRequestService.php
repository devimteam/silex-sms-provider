<?php

namespace Devim\Provider\SmsServiceProvider;

use Devim\Provider\SmsServiceProvider\Exception\SmsErrorException;
use Devim\Provider\SmsServiceProvider\Exception\SmsSendException;

class SmsRequestService
{
    /**
     * @param array $data
     * @param string $url
     *
     * @return string
     *
     * @throws SmsSendException
     * @throws SmsErrorException
     */
    public static function process(array $data, string $url) : string
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ];

        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($status !== 200) {
            throw new SmsSendException($status);
        }

        return $result;
    }
}
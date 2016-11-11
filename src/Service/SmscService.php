<?php

namespace Devim\Provider\SmsServiceProvider\Service;

use Devim\Provider\SmsServiceProvider\Helper\SmscResponseFilter;
use Devim\Provider\SmsServiceProvider\SmsRequestService;

class SmscService implements SmsServiceInterface
{
    const JSON_FORMAT = 3;
    const LAST_HOUR_RESULT = 1;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $urls;

    /**
     * SmscService constructor.
     *
     * @param string $login
     * @param string $password
     * @param array $urls
     */
    public function __construct(string $login, string $password, array $urls)
    {
        $this->login = $login;
        $this->password = $password;
        $this->urls = $urls;
    }

    /**
     * @param string $phone
     * @param string $text
     * @param string|null $shortCode
     *
     * @return array
     */
    public function send(string $phone, string $text, string $shortCode = null) : array
    {
        $data = [
            'phones' => $phone,
            'mes' => $text,
            'fmt' => self::JSON_FORMAT,
            'sender' => $shortCode
        ];
        $this->applyCredentials($data);

        return SmscResponseFilter::filter($this->decode(SmsRequestService::process($data, $this->urls['sendUrl'])));
    }

    /**
     * @param string $smsId
     * @param string|null $phone
     *
     * @return array
     */
    public function check(string $smsId, string $phone = null) : array
    {
        $data = [
            'phone' => $phone,
            'id' => $smsId,
            'fmt' => self::JSON_FORMAT
        ];
        $this->applyCredentials($data);

        return SmscResponseFilter::filter($this->decode(SmsRequestService::process($data, $this->urls['checkUrl'])));
    }

    /**
     * @return array
     */
    public function receive() : array
    {
        $data = [
            'fmt' => self::JSON_FORMAT,
            'hour' => self::LAST_HOUR_RESULT,
            'get_answers' => 1
        ];
        $this->applyCredentials($data);

        return SmscResponseFilter::filter($this->decode(SmsRequestService::process($data, $this->urls['receiveUrl'])));
    }

    /**
     * @param array $data
     */
    private function applyCredentials(array &$data)
    {
        $data['login'] = $this->login;
        $data['psw'] = $this->password;
    }

    private function decode(string $response)
    {
        return json_decode(iconv('CP1251', 'UTF-8', $response), true);
    }
}
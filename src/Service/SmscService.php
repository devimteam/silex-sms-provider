<?php

namespace Devim\Provider\SmsServiceProvider;

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
     * @var string
     */
    private $urls;

    /**
     * SmscService constructor.
     *
     * @param string $login
     * @param string $password
     * @param string $urls
     */
    public function __construct(string $login, string $password, string $urls)
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

        return $this->decode(SmsRequestService::process($data, $this->urls['send']));
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

        return $this->decode(SmsRequestService::process($data, $this->urls['send']));
    }

    /**
     * @return array
     */
    public function receive() : array
    {
        $data = [
            'fmt' => self::JSON_FORMAT,
            'hour' => self::LAST_HOUR_RESULT
        ];
        $this->applyCredentials($data);

        return $this->decode(SmsRequestService::process($data, $this->urls['send']));
    }

    /**
     * @param array $data
     */
    private function applyCredentials(array &$data)
    {
        $data['login'] = $this->login;
        $data['password'] = $this->password;
    }

    private function decode(string $response)
    {
        return json_decode(iconv('CP1251', 'UTF-8', $response), true);
    }
}
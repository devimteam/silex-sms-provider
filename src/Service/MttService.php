<?php

namespace Devim\Provider\SmsServiceProvider;

use Devim\Provider\SmsServiceProvider\Helper\MttResponseAnalyzer;

class MttService implements SmsServiceInterface
{
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
    private $url;

    /**
     * MttService constructor.
     *
     * @param string $login
     * @param string $password
     * @param string $url
     */
    public function __construct(string $login, string $password, string $url)
    {
        $this->login = $login;
        $this->password = $password;
        $this->url = $url;
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
            'msisdn' => $phone,
            'text' => $text,
            'shortcode' => $shortCode,
            'operation' => 'send',
        ];
        $this->applyCredentials($data);

        return MttResponseAnalyzer::check(SmsRequestService::process($data, $this->url));
    }

    /**
     * @param string $transactionId
     * @param string|null $phone
     *
     * @return array
     */
    public function check(string $transactionId, string $phone = null) : array
    {
        $data = [
            'id' => $transactionId,
            'operation' => 'status'
        ];
        $this->applyCredentials($data);

        return MttResponseAnalyzer::check(SmsRequestService::process($data, $this->url));
    }

    /**
     * @return array
     */
    public function receive()
    {
        return [];
    }

    /**
     * @param $data
     */
    private function applyCredentials(array &$data)
    {
        $data['login'] = $this->login;
        $data['password'] = $this->password;
    }
}
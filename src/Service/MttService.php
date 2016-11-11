<?php

namespace Devim\Provider\SmsServiceProvider\Service;

use Devim\Provider\SmsServiceProvider\Helper\MttResponseFilter;
use Devim\Provider\SmsServiceProvider\SmsRequestService;

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
     * @return string
     */
    public function send(string $phone, string $text, string $shortCode = null) : string
    {
        $data = [
            'msisdn' => $phone,
            'text' => $text,
            'shortcode' => $shortCode,
            'operation' => 'send',
        ];
        $this->applyCredentialsAndBuildParams($data);

        return MttResponseFilter::filter(SmsRequestService::process($data, $this->url));
    }

    /**
     * @param string $transactionId
     * @param string|null $phone
     *
     * @return int
     */
    public function check(string $transactionId, string $phone = null) : int
    {
        $data = [
            'id' => $transactionId,
            'operation' => 'status'
        ];
        $this->applyCredentialsAndBuildParams($data);

        return MttResponseFilter::filter(SmsRequestService::process($data, $this->url));
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
    private function applyCredentialsAndBuildParams(array &$data)
    {
        $data['login'] = $this->login;
        $data['password'] = $this->password;

        $data = http_build_query($data);
    }
}
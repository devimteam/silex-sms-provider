<?php

namespace Devim\Provider\SmsServiceProvider;

use Devim\Provider\SmsServiceProvider\Service\MttService;
use Devim\Provider\SmsServiceProvider\Service\SmscService;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class SmsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['mtt.login'] = '';
        $container['mtt.password'] = '';
        $container['mtt.url'] = '';

        $container['smsc.login'] = '';
        $container['smsc.password'] = '';
        $container['smsc.urls'] = [
            'sendUrl' => '',
            'receiveUrl' => '',
            'checkUrl' => ''
        ];

        $container['sms.mtt'] = function () use ($container) {
            return new MttService($container['mtt.login'], $container['mtt.password'], $container['mtt.url']);
        };

        $container['sms.smsc'] = function () use ($container) {
            return new SmscService($container['smsc.login'], $container['smsc.password'], $container['smsc.urls']);
        };
    }
}
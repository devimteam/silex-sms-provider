<?php

namespace Devim\Provider\SmsServiceProvider;

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

        $container['mtt.sms'] = function () use ($container) {
            return new MttService($container['mtt.login'], $container['mtt.password'], $container['mtt.url']);
        };

        $container['smsc.sms'] = function () use ($container) {
            return new SmscService($container['smsc.login'], $container['smsc.password'], $container['smsc.urls']);
        };
    }
}
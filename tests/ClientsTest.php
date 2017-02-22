<?php

namespace go1\util\tests;

use Doctrine\Common\Cache\ArrayCache;
use go1\clients\ClientServiceProvider;
use go1\clients\CurrencyClient;
use go1\clients\GraphinClient;
use go1\clients\LoClient;
use go1\clients\MailClient;
use go1\clients\PortalClient;
use go1\clients\QueueClient;
use go1\clients\RulesClient;
use go1\clients\SmsClient;
use go1\util\Service;
use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;
use Pimple\Container;
use Psr\Log\LoggerInterface;

class ClientsTest extends PHPUnit_Framework_TestCase
{
    public function testContainerValidation()
    {
        $logger = $this
            ->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['error'])
            ->getMockForAbstractClass();

        $services = ['queue', 'user', 'mail', 'portal', 'rules', 'currency', 'lo', 'sms', 'graphin'];
        $c = new Container;
        $c
            ->register(new ClientServiceProvider, [
                    'logger'       => $logger,
                    'client'       => new Client,
                    'cache'        => new ArrayCache,
                    'queueOptions' => [
                        'host' => '172.31.11.129',
                        'port' => '5672',
                        'user' => 'go1',
                        'pass' => 'go1',
                    ],
                ] + Service::urls($services, 'qa'));

        $this->assertTrue($c['go1.client.portal'] instanceof PortalClient);
        $this->assertTrue($c['go1.client.graphin'] instanceof GraphinClient);
        $this->assertTrue($c['go1.client.rules'] instanceof RulesClient);
        $this->assertTrue($c['go1.client.currency'] instanceof CurrencyClient);
        $this->assertTrue($c['go1.client.lo'] instanceof LoClient);
        $this->assertTrue($c['go1.client.queue'] instanceof QueueClient);
        $this->assertTrue($c['go1.client.mail'] instanceof MailClient);
        $this->assertTrue($c['go1.client.sms'] instanceof SmsClient);
    }
}
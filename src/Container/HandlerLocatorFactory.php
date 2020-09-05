<?php

namespace Antidot\Tactician\Container;

use Antidot\Tactician\Container\Config\CommandBusConfig;
use League\Tactician\Container\ContainerLocator;
use Psr\Container\ContainerInterface;

class HandlerLocatorFactory
{
    public function __invoke(ContainerInterface $container, string $bus = 'command_bus'): ContainerLocator
    {
        /** @var array<string, array> $globalConfig */
        $globalConfig = $container->get('config');
        $config = CommandBusConfig::createFromArrayConfig($globalConfig[$bus]);

        return new ContainerLocator($container, $config->getHandlerMap());
    }
}

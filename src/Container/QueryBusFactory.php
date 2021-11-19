<?php

namespace Antidot\Tactician\Container;

use Antidot\Tactician\Container\Config\CommandBusConfig;
use Antidot\Tactician\QueryBus;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use Psr\Container\ContainerInterface;

class QueryBusFactory
{
    public function __invoke(ContainerInterface $container): QueryBus
    {
        /** @var array<string, array> $globalConfig */
        $globalConfig = $container->get('config');
        $config = CommandBusConfig::createFromArrayConfig($globalConfig['query_bus']);

        /** @psalm-suppress MixedArgumentTypeCoercion
         *  @psalm-suppress MixedArgument
        */
        return new QueryBus(new CommandBus(array_merge(
            array_map(static function (string $middleware) use ($container) {
                return $container->get($middleware);
            }, $config->getMiddleware()),
            [
                new CommandHandlerMiddleware(
                    /** @var CommandNameExtractor $nameExtractor */
                    $container->get($config->getExtractor()),
                    /** @var HandlerLocator $locator */
                    $container->get($config->getLocator()),
                    /** @var MethodNameInflector $inflector */
                    $container->get($config->getInflector())
                ),
            ]
        )));
    }
}

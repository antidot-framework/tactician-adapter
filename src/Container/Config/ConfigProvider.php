<?php

namespace Antidot\Tactician\Container\Config;

use Antidot\Tactician\Container\CommandBusFactory;
use Antidot\Tactician\Container\HandlerLocatorFactory;
use Antidot\Tactician\Container\QueryBusFactory;
use Antidot\Tactician\QueryBus;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Plugins\LockingMiddleware;

class ConfigProvider
{
    public const COMMAND_BUS = [
        'locator' => HandlerLocator::class,
        'inflector' => MethodNameInflector::class,
        'extractor' => CommandNameExtractor::class,
        'middleware' => [
            LockingMiddleware::class => LockingMiddleware::class,
        ],
        'handler_map' => [
        ],
    ];
    public const QUERY_BUS = [
        'locator' => 'query_bus.handler_locator',
        'inflector' => MethodNameInflector::class,
        'extractor' => CommandNameExtractor::class,
        'middleware' => [
        ],
        'handler_map' => [
        ],
    ];
    public const DEPENDENCIES = [
        'factories' => [
            CommandBus::class => CommandBusFactory::class,
            QueryBus::class => QueryBusFactory::class,
            HandlerLocator::class => [HandlerLocatorFactory::class, 'command_bus'],
            'query_bus.handler_locator' => [HandlerLocatorFactory::class, 'query_bus'],        ],
        'invokables' => [
            MethodNameInflector::class => InvokeInflector::class,
            CommandNameExtractor::class => ClassNameExtractor::class,
            LockingMiddleware::class => LockingMiddleware::class,
        ],
    ];

    public function __invoke(): array
    {
        return [
            'command_bus' => self::COMMAND_BUS,
            'query_bus' => self::QUERY_BUS,
            'dependencies' => self::DEPENDENCIES,
        ];
    }
}

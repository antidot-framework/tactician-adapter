<?php

namespace Antidot\Tactician\Container\Config;

use Antidot\Tactician\Container\CommandBusFactory;
use Antidot\Tactician\Container\HandlerLocatorFactory;
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
    public const DEPENDENCIES = [
        'factories' => [
            CommandBus::class => CommandBusFactory::class,
            HandlerLocator::class => [HandlerLocatorFactory::class, 'command_bus'],
        ],
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
            'dependencies' => self::DEPENDENCIES,
        ];
    }
}

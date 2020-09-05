<?php

namespace AntidotTest\Tactician\Container;

use Antidot\Tactician\Container\CommandBusFactory;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Plugins\LockingMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CommandBusFactoryTest extends TestCase
{
    public function testItShouldCreateInstancesOfCommandBus(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(5))
            ->method('get')
            ->withConsecutive(
                ['config'],
                [LockingMiddleware::class],
                [CommandNameExtractor::class],
                [HandlerLocator::class],
                [MethodNameInflector::class]
            )->willReturnOnConsecutiveCalls(
                [
                    'command_bus' => [
                        'locator' => HandlerLocator::class,
                        'inflector' => MethodNameInflector::class,
                        'extractor' => CommandNameExtractor::class,
                        'middleware' => [
                            LockingMiddleware::class => LockingMiddleware::class,
                        ],
                        'handler_map' => [
                        ],
                    ],
                ],
                $this->createMock(LockingMiddleware::class),
                $this->createMock(CommandNameExtractor::class),
                $this->createMock(HandlerLocator::class),
                $this->createMock(MethodNameInflector::class),
            );
        $factory = new CommandBusFactory();
        $factory->__invoke($container);
    }
}

<?php

namespace AntidotTest\Tactician\Container;

use Antidot\Tactician\Container\QueryBusFactory;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Middleware;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class QueryBusFactoryTest extends TestCase
{
    public function testItShouldCreateInstancesOfQueryBus(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(5))
            ->method('get')
            ->withConsecutive(
                ['config'],
                ['some_middleware'],
                [CommandNameExtractor::class],
                ['query_bus.handler_locator'],
                [MethodNameInflector::class]
            )->willReturnOnConsecutiveCalls(
                [
                    'query_bus' => [
                        'locator' => 'query_bus.handler_locator',
                        'inflector' => MethodNameInflector::class,
                        'extractor' => CommandNameExtractor::class,
                        'middleware' => [
                            'some_middleware' => 'some_middleware',
                        ],
                        'handler_map' => [
                        ],
                    ]
                ],
                $this->createMock(Middleware::class),
                $this->createMock(CommandNameExtractor::class),
                $this->createMock(HandlerLocator::class),
                $this->createMock(MethodNameInflector::class),
            );
        $factory = new QueryBusFactory();
        $factory->__invoke($container);
    }
}

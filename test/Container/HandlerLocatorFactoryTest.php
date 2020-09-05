<?php

namespace AntidotTest\Tactician\Container;

use Antidot\Tactician\Container\Config\ConfigProvider;
use Antidot\Tactician\Container\HandlerLocatorFactory;
use AntidotTest\Tactician\TestCommand;
use AntidotTest\Tactician\TestHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class HandlerLocatorFactoryTest extends TestCase
{
    /** @dataProvider getHandlerMap */
    public function testItShouldCreateInstancesOfHandlerLocator(array $config): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(4))
            ->method('get')
            ->withConsecutive(['config'], [TestHandler::class], ['some_handler'], ['some_other_handler'])
            ->willReturnOnConsecutiveCalls(
                $config,
                $this->createMock(TestHandler::class),
                $this->createMock(\SplObjectStorage::class),
                $this->createMock(\SplFixedArray::class)
            );
        $factory = new HandlerLocatorFactory();
        $handlerLocator = $factory->__invoke($container);
        $this->assertInstanceOf(TestHandler::class, $handlerLocator->getHandlerForCommand(
            TestCommand::class
        ));
        $this->assertInstanceOf(\SplObjectStorage::class, $handlerLocator->getHandlerForCommand(
            'some_command'
        ));
        $this->assertInstanceOf(\SplFixedArray::class, $handlerLocator->getHandlerForCommand(
            'some_other_command',
        ));
    }

    public function getHandlerMap(): array
    {
        $defaultConfig = (new ConfigProvider())();

        return [
            'having 3 commands and handlers' => [
                array_replace_recursive($defaultConfig, [
                    'command_bus' => [
                        'handler_map' => [
                            TestCommand::class => TestHandler::class,
                            'some_command' => 'some_handler',
                            'some_other_command' => 'some_other_handler',
                        ],
                    ],
                ]),
            ],
        ];
    }
}

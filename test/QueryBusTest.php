<?php

namespace AntidotTest\Tactician;

use Antidot\Tactician\QueryBus;
use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;

class QueryBusTest extends TestCase
{
    public function testItShouldDelegateHandleQueriesToTacticianCommandBus(): void
    {
        $queryResult = $this->createMock(\SplFixedArray::class);
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(\SplObjectStorage::class))
            ->willReturn($queryResult);
        $queryBus = new QueryBus($bus);

        $this->assertSame(
            $queryResult,
            $queryBus->handle(new \SplObjectStorage())
        );
    }
}

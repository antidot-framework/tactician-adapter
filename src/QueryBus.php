<?php

namespace Antidot\Tactician;

use League\Tactician\CommandBus;

class QueryBus
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param object $query
     * @return object
     */
    public function handle(object $query): object
    {
        /** @var object $queryResult */
        $queryResult = $this->commandBus->handle($query);

        return $queryResult;
    }
}

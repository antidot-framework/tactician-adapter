# Antidot Framework Tactician Adapter

[League tactician](http://tactician.thephpleague.com/) command bus adapter for [Antidot Framework](https://antidotfw.io/) and [zend-expressive framework](https://docs.zendframework.com/zend-expressive/).

## Getting started

### Installation

````
composer require antidot-fw/tactician
````

### Config

Create `command-bus.global.php` file inner config autoload directory.

````php
<?php
// command-bus.global.php

return [
    'dependencies' => [
        'invokables' => [
            \App\Handler\PingHandler::class => \App\Handler\PingHandler::class,
        ]
    ],
    'command-bus' => [
        'handler-map' => [
            \App\Command\PingCommand::class => \App\Handler\PingHandler::class
        ],
    ],
];
````

Example command and handler.

````php
<?php

namespace App\Command;

class PingCommand
{

}
````

````php
<?php

namespace App\Handler;

use App\Command\PingCommand;

class PingHandler
{
    public function __invoke(PingCommand $command)
    {
        return time();
    }
}

````

You can use `InFw\TacticianAdapter\Action\AbstractAction` as base action.

````php
<?php

namespace App\Action;

use App\Command\PingCommand;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class PingAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['ack' => $this->bus->handle(new PingCommand())]);
    }
}
````

## Modify Command Bus

You can modify the entire command bus to meet the needs of your project.

This is default config.

````php
<?php
// command-bus.global.php

return [
    ...,
    'command_bus' => [
        'locator' => \League\Tactician\Handler\Locator\HandlerLocator::class,
        'inflector' => \League\Tactician\Handler\MethodNameInflector\MethodNameInflector::class,
        'extractor' => \League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor::class,
        'middleware' => [
            \League\Tactician\Plugins\LockingMiddleware::class,
            \League\Tactician\Logger\LoggerMiddleware::class,
            \League\Tactician\CommandEvents\EventMiddleware::class,

        ],
    ],
];
````

## Query Bus

You can use a query bus too, the difference with the command bus is that the query bus will always return an object.

```php
<?php
// command-bus.global.php

return [
    ...,
    'query_bus' => [
        'locator' => 'query_bus.handler_locator',
        'inflector' => \League\Tactician\Handler\MethodNameInflector\MethodNameInflector::class,
        'extractor' => \League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor::class,
        'middleware' => [

        ],
    ],
];
```

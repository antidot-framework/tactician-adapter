<?php


namespace Antidot\Tactician\Container\Config;

class CommandBusConfig
{
    private array $middleware;
    private array $handlerMap;
    private string $extractor;
    private string $locator;
    private string $inflector;

    private function __construct(
        array $middleware,
        array $handlerMap,
        string $extractor,
        string $inflector,
        string $locator
    ) {
        $this->middleware = $middleware;
        $this->handlerMap = $handlerMap;
        $this->extractor = $extractor;
        $this->inflector = $inflector;
        $this->locator = $locator;
    }

    public static function createFromArrayConfig(array $config): self
    {
        /** @var array<string, string> $middleware */
        $middleware = $config['middleware'];
        /** @var array<string, string> $handlerMap */
        $handlerMap = $config['handler_map'];
        /** @var string $extractor */
        $extractor = $config['extractor'];
        /** @var string $inflector */
        $inflector = $config['inflector'];
        /** @var string $locator */
        $locator = $config['locator'];

        return new self(
            $middleware,
            $handlerMap,
            $extractor,
            $inflector,
            $locator
        );
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getHandlerMap(): array
    {
        return $this->handlerMap;
    }

    public function getExtractor(): string
    {
        return $this->extractor;
    }

    public function getLocator(): string
    {
        return $this->locator;
    }

    public function getInflector(): string
    {
        return $this->inflector;
    }
}

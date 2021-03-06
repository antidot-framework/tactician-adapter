<?php

namespace AntidotTest\Tactician\Container\Config;

use Antidot\Tactician\Container\Config\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testItShouldReturnTheConfigArray(): void
    {
        $configProvider = new ConfigProvider();
        $config = $configProvider();
        $this->assertIsArray($config);

        $this->assertSame(ConfigProvider::COMMAND_BUS, $config['command_bus']);
        $this->assertSame(ConfigProvider::DEPENDENCIES, $config['dependencies']);
    }
}

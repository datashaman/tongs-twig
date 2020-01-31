<?php

declare(strict_types=1);

namespace Datashaman\Tongs\Plugins\Tests;

use Datashaman\Tongs\Tongs;
use Datashaman\Tongs\Plugins\TwigPlugin;

class TwigPluginTest extends TestCase
{
    public function testHandle()
    {
        $tongs = new Tongs($this->fixture('example-scenario'));
        $tongs->use(new TwigPlugin([
            'templates' => __DIR__ . '/templates',
        ]));
        $tongs->build();
        $this->assertDirEquals($this->fixture('example-scenario/expected'), $this->fixture('example-scenario/build'));
    }
}

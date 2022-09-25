<?php

namespace Tests\Unit;

use App\Console\Commands\ScrapWebsite;
use App\Spiders\WirelessSpider;
use PHPUnit\Framework\TestCase;
use RoachPHP\Roach;

class SpiderCommandTest extends TestCase
{

    protected function tearDown(): void
    {
        Roach::restore();
    }

    public function testCorrectSpiderRunGetsStarted(): void
    {
        $runner = Roach::fake();
        $command = new ScrapWebsite();
        $command->handle();

        $runner->assertRunWasStarted(WirelessSpider::class);
    }
}

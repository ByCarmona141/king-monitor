<?php

namespace ByCarmona141\KingMonitor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use KingMonitor;
use ByCarmona141\KingMonitor\Tests\TestCase;
use ByCarmona141\KingMonitor\Models\KingTypeError;
use ByCarmona141\KingMonitor\Models\KingMonitor as KingMonitorModel;

class KingMonitorTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    function it_return_the_view() {
        $this->assertEquals(
            'clase monitor',
            KingMonitor::hello()
        );
    }

    /** @test */
    function can_interact_with_models_and_databases() {
        $king = new KingTypeError();

        $king->name = 'GG';
        $king->save();

        $this->assertEquals('GG', KingTypeError::first()->content);
    }
}
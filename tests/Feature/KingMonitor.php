<?php

namespace ByCarmona141\KingMonitor\Tests\Feature;

use ByCarmona141\KingMonitor\Tests\TestCase;

class KingMonitor extends TestCase {
    /** @test */
    function can_get_the_message() {
        $this->get('/monitor')->assertSee('clase monitor');
    }

    /** @test */
    function can_get_the_view() {
        $this->withoutExceptionHandling();
        $this->get('/monitor')->assertViewIs('king-monitor::monitor');
    }
}
<?php

namespace Tests\Feature\Api2;

use Tests\TestCase;

class LocaleHeader extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->get('/api2/health')->assertContent('health.ok');
        $this->get('/api2/health', ['Accept-Language' => 'uk'])->assertContent('все добре');
    }
}

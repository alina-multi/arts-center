<?php

/**
 * A basic feature test example.
 */
test('locale header', function () {
    $this->get('/api2/health')->assertContent('health.ok');
    $this->get('/api2/health', ['Accept-Language' => 'uk'])->assertContent('все добре');
});

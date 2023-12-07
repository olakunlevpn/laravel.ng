<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LicenseCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_license_check_returns_status_204_for_valid_license(): void
    {

        $validLicenseKey = '86781236-23d0-4b3c-7dfa-c1c147e0dece';

        $response = $this->postJson('/api/license-check', [
            'url' => 'http://testurl.com',
            'key' => $validLicenseKey,
        ]);

        $response->assertStatus(204);
    }
}

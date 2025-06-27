<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;

class AdFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/ads');
    }

    public function test_xss_protection_on_show()
    {
        $ad = \App\Models\Ad::factory()->create(['name' => '<script>alert(1)</script>']);
        $response = $this->get('/ads/' . $ad->id);
        $response->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_sql_injection_protection()
    {
        $response = $this->get('/ads/999999');
        $response->assertStatus(404);
    }
}

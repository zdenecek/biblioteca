<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settins_screen_can_be_rendered()
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get(route('admin.web_settings'));

        $response->assertStatus(200);
    }
}

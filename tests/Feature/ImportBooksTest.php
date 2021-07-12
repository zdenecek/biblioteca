<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportBooksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_books_can_be_imported()
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->postJson('/import', [
            'books' => [[
                'title' => 'Název mojí knížky',
                'author_last_name' => 'Frank',
                'collection' => '1',
                'code' => 'testxxx',
                'section' => '1',
                'maturita' => 'true',
            ]]
        ]);

        $response->assertStatus(200);
    }
}

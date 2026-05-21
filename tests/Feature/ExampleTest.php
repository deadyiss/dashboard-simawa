<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // 1. Buat user tiruan
        $user = User::factory()->create();

        // 2. Gunakan ->followingRedirects() agar Laravel otomatis mengejar ke mana halaman itu dilempar
        $response = $this->actingAs($user)
                         ->followingRedirects()
                         ->get('/');

        // 3. Pastikan halaman tujuan akhir (setelah redirect) mengembalikan status 200 OK
        $response->assertStatus(200);
    }
}
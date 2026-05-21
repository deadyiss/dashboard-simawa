<?php

namespace Tests\Feature;

use App\Models\User; // Pastikan model User di-import
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Memastikan database di-reset setiap kali tes dijalankan

    public function test_the_application_returns_a_successful_response(): void
    {
        // Membuat data user tiruan di dalam database memory (sqlite)
        $user = User::factory()->create();

        // Mengakses halaman '/' sambil membawa sesi user yang sudah login
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
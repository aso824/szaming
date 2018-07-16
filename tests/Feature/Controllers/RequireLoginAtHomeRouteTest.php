<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequireLoginAtHomeRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testAsGuest(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function testAsUser(): void
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
}

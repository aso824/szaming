<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;

class RequireLoginAtHomeRouteTest extends TestCase
{
    public function testAsGuest()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function testAsUser()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
}

<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $newData = [
        'email' => 'test@example.com',
        'name' => 'Test'
    ];

    public function testIndexView(): void
    {
        $user = $this->setupUser();

        $response = $this->actingAs($user)
                         ->get(route('profile.index'));

        $response->assertStatus(Response::HTTP_OK)
                 ->assertViewIs('profile.index');
    }

    public function testIndexViewAsUnauthenticated(): void
    {
        $response = $this->get(route('profile.index'));

        $response->assertStatus(Response::HTTP_FOUND)
                 ->assertRedirect(route('login'));
    }

    public function testProfileUpdate(): void
    {
        $user = $this->setupUser();

        $this->patch(route('profile.update', [
            'profile' => $user->id,
        ]), $this->newData)
             ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', $this->newData);
    }

    public function testUnauthorizedProfileUpdate(): void
    {
        [$user1, $user2] = $user = factory(\App\Models\User::class, 2)->create();
        $this->actingAs($user1);

        $this->patch(route('profile.update', [
            'profile' => $user2->id,
        ]), $this->newData)
             ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('users', $this->newData);
    }

    protected function setupUser(): \App\Models\User
    {
        $user = factory(\App\Models\User::class)->create();
        $this->actingAs($user);

        return $user;
    }
}

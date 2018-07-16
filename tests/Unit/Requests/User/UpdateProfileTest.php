<?php

namespace Tests\Unit\Requests\User;

use App\Http\Requests\User\UpdateProfileRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulAuthorization(): void
    {
        $user = factory(\App\Models\User::class)->create();
        $this->actingAs($user);

        $request = new UpdateProfileRequest([], [], [], [], [], ['REQUEST_URI' => 'profile/' . $user->id]);
        $request->setRouteResolver(function () use ($request) {
            return (new Route(['PUT', 'PATCH'], 'profile/{profile}', []))->bind($request);
        });

        $this->assertTrue($request->authorize());
    }
}

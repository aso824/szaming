<?php

namespace Tests\Unit\Services\User;

use App\Models\User;
use App\Services\User\UserAjaxService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAjaxServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Services\User\UserAjaxService
     */
    protected $service;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $shops;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(UserAjaxService::class);
        $this->shops = factory(User::class, 5)->create();
    }

    public function testGetListWithoutParameters(): void
    {
        $result = $this->service->getList();

        $this->assertEquals($result, $this->shops->pluck('name', 'id')->toArray());
    }

    /**
     * @depends testGetListWithoutParameters
     */
    public function testGetListWithSearchQuery(): void
    {
        $this->shops->push(factory(User::class)->create(['name' => 'Foo bar']));

        $result = $this->service->getList('foo');

        $this->assertArraySubset([6 => 'Foo bar'], $result);
    }

    /**
     * @depends testGetListWithSearchQuery
     */
    public function testGetListWithLimit(): void
    {
        $result = $this->service->getList('', 2);

        $this->assertCount(2, $result);
    }

    /**
     * @depends testGetListWithSearchQuery
     * @depends testGetListWithLimit
     */
    public function testGetListWithSearchQueryAndLimit(): void
    {
        $this->shops->push(factory(User::class)->create(['name' => 'Foo bar']));        // ID = 6
        $this->shops->push(factory(User::class)->create(['name' => 'Bar foo']));        // ID = 7
        $this->shops->push(factory(User::class)->create(['name' => 'foo baz foo']));    // ID = 8

        $result = $this->service->getList('foo', 2);

        $this->assertArraySubset([6 => 'Foo bar'], $result);
        $this->assertArraySubset([7 => 'Bar foo'], $result);
        $this->assertCount(2, $result);
    }
}
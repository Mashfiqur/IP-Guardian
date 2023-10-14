<?php

namespace Tests\Unit\IPAddress;

use App\Http\Controllers\IPAddress\IPAddressController;
use App\Http\Resources\IPAddress\IPAddressResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\IPAddress;
use Illuminate\Http\Request;

class IPAddressResourceUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_of_controller()
    {
        IPAddress::factory(5)->create();

        $controller = new IPAddressController(new IPAddress);

        $request = Request::create(config('test.urls.ip_address'), 'GET');

        $response = $controller->index($request);

        $this->assertEquals(5, $response->count());
    }

    public function test_show_displays_ip_address()
    {
        $ipAddress = IPAddress::factory()->create();

        $controller = new IPAddressController(new IPAddress);

        $response = $controller->show($ipAddress->{config('uuid.column')});

        $this->assertInstanceOf(IPAddressResource::class, $response);
    }
}

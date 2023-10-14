<?php

namespace Tests\Feature\IPAddress;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\IPAddress;
use App\Models\User;

class IPAddressResourceFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $bearerToken;

    public function setUp(): void
    {
        parent::setUp();
        
        $user = User::create([
            'name'      => 'Test User',
            'email'     => 'test@example.com',
            'password'  => 'password',
        ]);

        $this->bearerToken = $user->createToken('test-token')->plainTextToken;
    }

    public function test_authenticated_user_can_get_paginated_ip_addresses()
    {

        IPAddress::factory(5)->create();

        $response = $this->withHeader('Authorization', "Bearer $this->bearerToken")
            ->getJson(config('test.urls.ip_address'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'ip',
                        'label', 
                        'comment'
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_authenticated_user_can_create_ip_address()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->bearerToken")
            ->postJson(config('test.urls.ip_address'), [
                'label' => 'Test IP',
                'ip' => '192.168.1.1',
                'comment' => 'Test Comment',
            ]);

        $response->assertStatus(201)
                ->assertJsonStructure(['data' => [
                    'id',
                    'ip',
                    'label', 
                    'comment'
                    ]
                ]);

        $this->assertDatabaseHas('ip_addresses', ['label' => 'Test IP']);

        $ipAddress = IPAddress::where('label', 'Test IP')->first();
    
        $auditLog = $ipAddress->audit_logs->first();

        $this->assertNotNull($auditLog);
    }

    public function test_authenticated_user_can_view_ip_address()
    {
        $ipAddress = IpAddress::create([
            'label' => 'Task IP',
            'ip' => '172.19.11.1',
            'comment' => 'Task Comment',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->bearerToken")
            ->get(config('test.urls.ip_address') . "/" . $ipAddress->{config('uuid.column')});

        $response->assertStatus(200)
            ->assertJsonStructure(["data" => ["id", "label", "ip", "comment", "audit_logs"]]);
    }

    public function test_authenticated_user_can_edit_ip_address()
    {
        $ipAddress = IpAddress::create([
            'label' => 'Task IP',
            'ip' => '172.19.11.1',
            'comment' => 'Task Comment',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->bearerToken")
            ->get(config('test.urls.ip_address') . "/" . $ipAddress->{config('uuid.column')} . "/edit");

        $response->assertStatus(200)
            ->assertJsonStructure(["data" => ["id", "label", "ip", "comment"]]);
    }

    public function test_authenticated_user_can_update_ip_address()
    {
        $ipAddress = IpAddress::create([
            'label' => 'Initial IP',
            'ip' => '112.18.1.1',
            'comment' => 'Initial Comment',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->bearerToken")
            ->putJson(config('test.urls.ip_address') . "/" . $ipAddress->{config('uuid.column')}, [
                'label' => 'Updated Label',
                'comment' => 'Updated Comment',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('ip_addresses', [
            'label' => 'Updated Label',
            'comment' => 'Updated Comment',
        ]);
    }
}

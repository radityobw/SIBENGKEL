<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use App\Models\ServiceTransaction;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RestApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_returns_token_for_valid_credentials_and_rejects_invalid(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $valid = $this->postJson('/api/login', [
            'login' => $user->email,
            'password' => 'password123',
        ]);

        $valid->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'access_token', 'token_type', 'user']);

        $invalid = $this->postJson('/api/login', [
            'login' => $user->email,
            'password' => 'wrong-password',
        ]);

        $invalid->assertStatus(401)
            ->assertJsonPath('success', false);
    }

    public function test_api_customers_requires_sanctum_token(): void
    {
        $this->getJson('/api/customers')->assertStatus(401);

        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $this->getJson('/api/customers')
            ->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_api_transaction_status_returns_404_when_missing_and_payload_when_found(): void
    {
        $this->getJson('/api/transactions/999999/status')
            ->assertStatus(404)
            ->assertExactJson(['error' => 'Not found']);

        $customer = Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
        ]);

        $vehicle = Vehicle::create([
            'customer_id' => $customer->id,
            'plate_number' => 'B 4321 TEST',
            'brand' => 'Honda',
            'model' => 'Beat',
            'year' => 2024,
        ]);

        $tx = ServiceTransaction::create([
            'vehicle_id' => $vehicle->id,
            'complaint' => 'Servis rutin berkala',
            'cost' => 150000,
            'status' => 'proses',
            'transaction_date' => now()->format('Y-m-d'),
        ]);

        $this->getJson("/api/transactions/{$tx->id}/status")
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'status_label', 'updated_at'])
            ->assertJsonPath('status', 'proses');
    }
}

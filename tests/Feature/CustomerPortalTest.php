<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_customer_portal(): void
    {
        $this->get('/portal')->assertRedirect('/');
    }

    public function test_authenticated_customer_can_access_portal(): void
    {
        $customer = Customer::create([
            'name' => 'Pelanggan Portal',
            'phone' => '081299990001',
            'email' => 'portal.test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($customer, 'customer')
            ->get('/portal')
            ->assertStatus(200);
    }
}

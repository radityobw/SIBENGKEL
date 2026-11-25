<?php

namespace Tests\Feature;

use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function test_customer_password_reset_with_valid_otp_clears_reset_session(): void
    {
        Mail::fake();

        $customer = Customer::create([
            'name' => 'Pelanggan OTP',
            'phone' => '081299990002',
            'email' => 'otp.test@example.com',
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->post('/lupa-password/send-otp', ['email' => $customer->email])
            ->assertRedirect(route('public.forgot_password.verify'));

        Mail::assertSent(OtpMail::class);

        $otp = session('reset_otp');
        $this->assertMatchesRegularExpression('/^\d{6}$/', (string) $otp);

        $this->post('/lupa-password/reset', [
            'otp' => $otp,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertRedirect(route('public.login'));

        $this->assertTrue(Hash::check('newpassword123', $customer->refresh()->password));
        $this->assertFalse(session()->has('reset_email'));
        $this->assertFalse(session()->has('reset_otp'));
        $this->assertFalse(session()->has('reset_otp_expires'));
    }
}

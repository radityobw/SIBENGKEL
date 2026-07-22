<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin & Mekanik User Account
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@sibengkel.web.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mekanik Budi',
            'email' => 'mekanik@sibengkel.web.id',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
        ]);

        // Dummy Customer & Vehicle
        $customer = Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 10, Jakarta'
        ]);

        $vehicle = Vehicle::create([
            'customer_id' => $customer->id,
            'plate_number' => 'B 1234 XYZ',
            'brand' => 'Honda',
            'model' => 'Vario 150',
            'year' => 2022
        ]);

        $mechanic = Mechanic::create([
            'name' => 'Agus Teknis',
            'phone' => '089876543210',
            'expertise' => 'Spesialis Mesin & Injeksi'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

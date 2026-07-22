<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Mechanic;
use App\Models\ServiceTransaction;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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

        ServiceTransaction::create([
            'vehicle_id' => $vehicle->id,
            'user_id' => 1,
            'mechanic_id' => $mechanic->id,
            'type' => 'servis',
            'complaint' => 'Ganti Oli Mesin & Tune Up Rutin',
            'cost' => 350000.00,
            'status' => 'proses',
            'transaction_date' => now()->toDateString()
        ]);
    }
}

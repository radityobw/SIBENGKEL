<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Mechanic;
use App\Models\ServiceTransaction;
use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SparePart;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Download Avatar Images for realistic Profile Photos
        $avatarDir = storage_path('app/public/avatars');
        if (!file_exists($avatarDir)) {
            mkdir($avatarDir, 0755, true);
        }

        $avatarFiles = [];
        $avatarSources = [
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=300&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=300&auto=format&fit=crop&q=80',
        ];

        foreach ($avatarSources as $index => $url) {
            $filename = 'seed_avatar_' . ($index + 1) . '.jpg';
            $targetPath = $avatarDir . '/' . $filename;
            if (!file_exists($targetPath)) {
                $ctx = stream_context_create([
                    'http' => ['timeout' => 5, 'header' => "User-Agent: Mozilla/5.0\r\n"]
                ]);
                $imgData = @file_get_contents($url, false, $ctx);
                if ($imgData) {
                    file_put_contents($targetPath, $imgData);
                }
            }
            $avatarFiles[] = file_exists($targetPath) ? $filename : null;
        }

        // 2. Admin User
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@sibengkel.web.id'],
            [
                'name' => 'Admin Utama SIBENGKEL',
                'username' => 'adminbengkel',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'profile_photo' => $avatarFiles[0] ?? null,
            ]
        );

        // 3. Mechanics (User & Mechanic records)
        $mechanicsData = [
            [
                'name' => 'Mekanik Budi Raharjo',
                'username' => 'mekanikbudi',
                'email' => 'budi.mekanik@sibengkel.web.id',
                'phone' => '0811987654321',
                'expertise' => 'Spesialis Mesin & Injeksi (Senior)',
                'avatar' => $avatarFiles[1] ?? null,
            ],
            [
                'name' => 'Mekanik Agus Prasetyo',
                'username' => 'mekanikagus',
                'email' => 'agus.mekanik@sibengkel.web.id',
                'phone' => '0812987654322',
                'expertise' => 'Spesialis Kelistrikan & ECU',
                'avatar' => $avatarFiles[2] ?? null,
            ],
            [
                'name' => 'Mekanik Joko Widodo',
                'username' => 'mekanikjoko',
                'email' => 'joko.mekanik@sibengkel.web.id',
                'phone' => '0813987654323',
                'expertise' => 'Spesialis Kaki-Kaki & Rem',
                'avatar' => $avatarFiles[3] ?? null,
            ],
        ];

        $mechanicModels = [];
        foreach ($mechanicsData as $mData) {
            $mUser = User::updateOrCreate(
                ['email' => $mData['email']],
                [
                    'name' => $mData['name'],
                    'username' => $mData['username'],
                    'password' => Hash::make('password123'),
                    'role' => 'mekanik',
                    'profile_photo' => $mData['avatar'],
                ]
            );

            $mechanicModels[] = Mechanic::updateOrCreate(
                ['user_id' => $mUser->id],
                [
                    'name' => $mData['name'],
                    'phone' => $mData['phone'],
                    'expertise' => $mData['expertise'],
                ]
            );
        }

        // 4. Customers & Vehicles
        $customersData = [
            [
                'name' => 'Andi Budiman',
                'phone' => '081234567801',
                'email' => 'andi@example.com',
                'address' => 'Jl. Merdeka No. 12, Jakarta Selatan',
                'profile_photo' => $avatarFiles[4] ?? null,
                'vehicle' => ['plate_number' => 'B 1234 XYZ', 'brand' => 'Honda', 'model' => 'Vario 150', 'year' => 2022],
            ],
            [
                'name' => 'Siti Maimunah',
                'phone' => '081234567802',
                'email' => 'siti@example.com',
                'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
                'profile_photo' => $avatarFiles[5] ?? null,
                'vehicle' => ['plate_number' => 'B 5678 AB', 'brand' => 'Toyota', 'model' => 'Avanza Veloz', 'year' => 2020],
            ],
            [
                'name' => 'Dimas Riyanto',
                'phone' => '081234567803',
                'email' => 'dimas@example.com',
                'address' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan',
                'profile_photo' => $avatarFiles[6] ?? null,
                'vehicle' => ['plate_number' => 'B 9101 CD', 'brand' => 'Yamaha', 'model' => 'NMAX 155', 'year' => 2021],
            ],
            [
                'name' => 'Rina Wijaya',
                'phone' => '081234567804',
                'email' => 'rina@example.com',
                'address' => 'Jl. Ahmad Yani No. 23, Bandung',
                'profile_photo' => $avatarFiles[7] ?? null,
                'vehicle' => ['plate_number' => 'B 2345 EF', 'brand' => 'Honda', 'model' => 'Jazz RS', 'year' => 2019],
            ],
            [
                'name' => 'Hendra Kurniawan',
                'phone' => '081234567805',
                'email' => 'hendra@example.com',
                'address' => 'Jl. Kebon Jeruk No. 101, Jakarta Barat',
                'profile_photo' => $avatarFiles[8] ?? null,
                'vehicle' => ['plate_number' => 'B 6789 GH', 'brand' => 'Mitsubishi', 'model' => 'Pajero Sport', 'year' => 2023],
            ],
            [
                'name' => 'Dewi Lestari',
                'phone' => '081234567806',
                'email' => 'dewi@example.com',
                'address' => 'Jl. Diponegoro No. 5, Surabaya',
                'profile_photo' => $avatarFiles[9] ?? null,
                'vehicle' => ['plate_number' => 'B 3456 IJ', 'brand' => 'Yamaha', 'model' => 'Aerox 155', 'year' => 2022],
            ],
        ];

        $customerModels = [];
        $vehicleModels = [];

        foreach ($customersData as $cData) {
            $customer = Customer::updateOrCreate(
                ['phone' => $cData['phone']],
                [
                    'name' => $cData['name'],
                    'email' => $cData['email'],
                    'address' => $cData['address'],
                    'password' => Hash::make('password123'),
                    'profile_photo' => $cData['profile_photo'],
                ]
            );
            $customerModels[] = $customer;

            $vData = $cData['vehicle'];
            $vehicle = Vehicle::updateOrCreate(
                ['plate_number' => $vData['plate_number']],
                [
                    'customer_id' => $customer->id,
                    'brand' => $vData['brand'],
                    'model' => $vData['model'],
                    'year' => $vData['year'],
                ]
            );
            $vehicleModels[] = $vehicle;
        }

        // 5. Service Transactions over the last 14 days (for revenue chart & analytics)
        $complaints = [
            'Servis Berkala & Ganti Oli Mesin Sintetis',
            'Ganti Kampas Rem Depan & Belakang',
            'Tune Up Injeksi & Pembersihan Throttle Body',
            'Ganti Ban Tubeless & Balancing Velg',
            'Pemeriksaan Kelistrikan & Ganti Aki Kering GS Astra',
            'Kuras Air Radiator & Servis System Pendingin',
        ];

        // Seed 14 transactions for past 14 days
        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $vIndex = $i % count($vehicleModels);
            $mIndex = $i % count($mechanicModels);
            $cost = rand(15, 65) * 10000; // Rp 150.000 to Rp 650.000

            ServiceTransaction::create([
                'vehicle_id' => $vehicleModels[$vIndex]->id,
                'user_id' => $adminUser->id,
                'mechanic_id' => $mechanicModels[$mIndex]->id,
                'type' => ($i % 3 == 0) ? 'penjualan' : 'servis',
                'complaint' => $complaints[$i % count($complaints)],
                'cost' => $cost,
                'status' => ($i == 0) ? 'proses' : 'selesai',
                'transaction_date' => $date,
            ]);
        }

        // 6. Bookings (Versi Terbaru - dummy data lengkap untuk semua status dan pelanggan)
        // Booking 1: Menunggu Konfirmasi - Andi Budiman (Honda Vario 150)
        Booking::create([
            'customer_id' => $customerModels[0]->id,
            'vehicle_id' => $vehicleModels[0]->id,
            'preferred_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'preferred_time' => '08:30:00',
            'complaint' => 'Tarikan motor terasa berat dan ada suara bunyi decit di bagian transmisi CVT saat awal angkatan.',
            'status' => 'menunggu_konfirmasi',
        ]);

        // Booking 2: Menunggu Konfirmasi - Siti Maimunah (Toyota Avanza Veloz)
        Booking::create([
            'customer_id' => $customerModels[1]->id,
            'vehicle_id' => $vehicleModels[1]->id,
            'preferred_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'preferred_time' => '10:00:00',
            'complaint' => 'Lampu indikator Check Engine tiba-tiba menyala di dashboard dan mesin terasa sedikit bergetar saat idle.',
            'status' => 'menunggu_konfirmasi',
        ]);

        // Booking 3: Disetujui (Menunggu Mekanik) - Dimas Riyanto (Yamaha NMAX 155) -> Otomatis buat Service Transaction
        $txBooking1 = ServiceTransaction::create([
            'vehicle_id' => $vehicleModels[2]->id,
            'user_id' => $adminUser->id,
            'mechanic_id' => $mechanicModels[0]->id,
            'type' => 'servis',
            'complaint' => 'Servis berkala bulanan, ganti oli mesin sintetis Yamalube dan periksa tekanan rem hidrolik depan belakang.',
            'cost' => 185000,
            'status' => 'pending',
            'transaction_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        ]);

        Booking::create([
            'customer_id' => $customerModels[2]->id,
            'vehicle_id' => $vehicleModels[2]->id,
            'preferred_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'preferred_time' => '09:00:00',
            'complaint' => 'Servis berkala bulanan, ganti oli mesin sintetis Yamalube dan periksa tekanan rem hidrolik depan belakang.',
            'status' => 'disetujui',
            'service_transaction_id' => $txBooking1->id,
        ]);

        // Booking 4: Disetujui (Sedang Dikerjakan) - Rina Wijaya (Honda Jazz RS) -> Otomatis buat Service Transaction
        $txBooking2 = ServiceTransaction::create([
            'vehicle_id' => $vehicleModels[3]->id,
            'user_id' => $adminUser->id,
            'mechanic_id' => $mechanicModels[2]->id,
            'type' => 'servis',
            'complaint' => 'Tolong diperiksa suara bising di roda depan kiri saat pengereman mendadak dan ganti kampas rem orisinil.',
            'cost' => 450000,
            'status' => 'proses',
            'transaction_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        ]);

        Booking::create([
            'customer_id' => $customerModels[3]->id,
            'vehicle_id' => $vehicleModels[3]->id,
            'preferred_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'preferred_time' => '13:00:00',
            'complaint' => 'Tolong diperiksa suara bising di roda depan kiri saat pengereman mendadak dan ganti kampas rem orisinil.',
            'status' => 'disetujui',
            'service_transaction_id' => $txBooking2->id,
        ]);

        // Booking 5: Dikonversi (Servis Selesai) - Hendra Kurniawan (Mitsubishi Pajero Sport) -> Otomatis buat Service Transaction
        $txBooking3 = ServiceTransaction::create([
            'vehicle_id' => $vehicleModels[4]->id,
            'user_id' => $adminUser->id,
            'mechanic_id' => $mechanicModels[0]->id,
            'type' => 'servis',
            'complaint' => 'AC mobil kurang dingin dan ada bau apek saat dinyalakan pagi hari, perlu cuci evaporator dan ganti filter kabin.',
            'cost' => 650000,
            'status' => 'selesai',
            'transaction_date' => Carbon::now()->format('Y-m-d'),
        ]);

        Booking::create([
            'customer_id' => $customerModels[4]->id,
            'vehicle_id' => $vehicleModels[4]->id,
            'preferred_date' => Carbon::now()->format('Y-m-d'),
            'preferred_time' => '10:30:00',
            'complaint' => 'AC mobil kurang dingin dan ada bau apek saat dinyalakan pagi hari, perlu cuci evaporator dan ganti filter kabin.',
            'status' => 'disetujui',
            'service_transaction_id' => $txBooking3->id,
        ]);

        // Booking 6: Ditolak - Dewi Lestari (Yamaha Aerox 155)
        Booking::create([
            'customer_id' => $customerModels[5]->id,
            'vehicle_id' => $vehicleModels[5]->id,
            'preferred_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'preferred_time' => '14:00:00',
            'complaint' => 'Ingin modifikasi bore-up mesin harian menjadi 183cc dan ganti ECU racing programmable.',
            'status' => 'ditolak',
        ]);

        // 7. Seed SpareParts & Testimonials
        $this->call(SparePartSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(TestimonialSeeder::class);
    }
}

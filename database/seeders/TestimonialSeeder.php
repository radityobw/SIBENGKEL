<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Customer;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonialsData = [
            [
                'customer_name' => 'Andi Budiman',
                'vehicle' => 'Honda Vario 150 (2022)',
                'rating' => 5,
                'content' => 'Sistem bookingnya sangat memudahkan. Saya tidak perlu lagi antre lama di bengkel. Status servis juga bisa dicek langsung dari HP!',
                'is_active' => true,
            ],
            [
                'customer_name' => 'Siti Maimunah',
                'vehicle' => 'Toyota Avanza (2020)',
                'rating' => 5,
                'content' => 'Transparansi biayanya luar biasa. Saya tahu persis apa saja yang diganti dan berapa harganya sebelum mekanik mulai bekerja.',
                'is_active' => true,
            ],
            [
                'customer_name' => 'Dimas Riyanto',
                'vehicle' => 'Yamaha NMAX (2021)',
                'rating' => 5,
                'content' => 'Mekaniknya ramah dan profesional. Riwayat servis tersimpan dengan rapi di portal sehingga saya tahu kapan jadwal servis berikutnya.',
                'is_active' => true,
            ],
            [
                'customer_name' => 'Rina Wijaya',
                'vehicle' => 'Honda Jazz (2019)',
                'rating' => 5,
                'content' => 'Pelayanan cepat dan ruang tunggu nyaman. Pembayaran online dan invoice digitalnya sangat praktis.',
                'is_active' => true,
            ],
            [
                'customer_name' => 'Hendra Kurniawan',
                'vehicle' => 'Mitsubishi Pajero (2023)',
                'rating' => 4,
                'content' => 'Sparepart yang digunakan terjamin keasliannya dan hasil tune up mesin membuat performa mobil kembali responsif seperti baru.',
                'is_active' => true,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'vehicle' => 'Yamaha Aerox (2022)',
                'rating' => 5,
                'content' => 'Sangat puas servis di SIBENGKEL! Notifikasi booking lewat WhatsApp juga langsung masuk.',
                'is_active' => true,
            ],
        ];

        foreach ($testimonialsData as $data) {
            $customer = Customer::where('name', $data['customer_name'])->first();
            $data['customer_id'] = $customer ? $customer->id : null;
            Testimonial::updateOrCreate(
                ['customer_name' => $data['customer_name']],
                $data
            );
        }
    }
}

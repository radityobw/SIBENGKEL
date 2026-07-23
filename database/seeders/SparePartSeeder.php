<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SparePart;

class SparePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spareparts = [
            [
                'name' => 'Oli Mesin AHM Oil MPX2 0.8L (Matic)',
                'category' => 'Oli & Pelumas',
                'price' => 54000,
                'stock' => 45,
                'description' => 'Oli mesin sintetis presisi tinggi khusus sepeda motor matik Honda. Memaksimalkan efisiensi bahan bakar dan menjaga kebersihan mesin.',
                'image_path' => 'spareparts/mpx2.jpg',
            ],
            [
                'name' => 'Oli Mesin Yamalube Super Matic 1L',
                'category' => 'Oli & Pelumas',
                'price' => 72000,
                'stock' => 30,
                'description' => 'Oli full sintetis diformulasikan khusus untuk motor matic Yamaha berkapasitas 150cc ke atas seperti NMAX, Aerox, dan XMAX.',
                'image_path' => 'spareparts/yamalube.jpg',
            ],
            [
                'name' => 'Oli Shell Advance AX7 Matic 10W-40 0.8L',
                'category' => 'Oli & Pelumas',
                'price' => 62000,
                'stock' => 25,
                'description' => 'Oli pelumas sintetis dengan teknologi RCE, memberikan perlindungan ekstra terhadap keausan dan pembersihan deposit mesin.',
                'image_path' => 'spareparts/shell.jpg',
            ],
            [
                'name' => 'Kampas Rem Depan Honda Genuine Parts (BeAT / Vario / Scoopy)',
                'category' => 'Sistem Pengereman',
                'price' => 68000,
                'stock' => 50,
                'description' => 'Pad set front brake orisinal Honda AHM. Daya cengkeram optimal, tidak merusak piringan cakram, dan tahan panas tinggi.',
                'image_path' => 'spareparts/kampas_hgp.jpg',
            ],
            [
                'name' => 'Kampas Rem Belakang Tromol Aspira (Universal Matic)',
                'category' => 'Sistem Pengereman',
                'price' => 42000,
                'stock' => 35,
                'description' => 'Kampas rem tromol kualitas OEM buatan Astra Otoparts. Pakem, senyap, dan memiliki usia pakai lebih panjang.',
                'image_path' => 'spareparts/kampas_aspira.jpg',
            ],
            [
                'name' => 'Piringan Cakram Depan TDR Floating 220mm',
                'category' => 'Sistem Pengereman',
                'price' => 385000,
                'stock' => 12,
                'description' => 'Disc rotor floating kinerja tinggi untuk pelepasan panas lebih cepat dan respons pengereman yang jauh lebih presisi.',
                'image_path' => 'spareparts/cakram_tdr.jpg',
            ],
            [
                'name' => 'Ban Luar Tubeless FDR Sport Zevo 90/80-14',
                'category' => 'Ban & Velg',
                'price' => 265000,
                'stock' => 20,
                'description' => 'Ban tubeless harian sporty dengan kompon reguler dan desain alur tapak yang efisien dalam menyalurkan air.',
                'image_path' => 'spareparts/ban_fdr.jpg',
            ],
            [
                'name' => 'Ban Luar Tubeless Michelin City Grip 2 110/80-14',
                'category' => 'Ban & Velg',
                'price' => 480000,
                'stock' => 15,
                'description' => 'Ban premium dengan teknologi silica compound untuk performa cengkeram luar biasa di jalanan basah maupun kering.',
                'image_path' => 'spareparts/ban_michelin.jpg',
            ],
            [
                'name' => 'Aki Kering GS Astra GTZ6V (NMAX, Vario 150, PCX)',
                'category' => 'Kelistrikan & Aki',
                'price' => 295000,
                'stock' => 18,
                'description' => 'Aki bebas perawatan (Maintenance Free) berkapasitas 5Ah 12V. Daya starter kuat dan tahan terhadap getaran tinggi.',
                'image_path' => 'spareparts/aki_gs.jpg',
            ],
            [
                'name' => 'Busi NGK Iridium IX CPR9EAIX-9',
                'category' => 'Kelistrikan & Aki',
                'price' => 115000,
                'stock' => 40,
                'description' => 'Busi iridium kualitas balap dengan elektroda ultra tipis. Memperbaiki respon akselerasi dan pembakaran lebih sempurna.',
                'image_path' => 'spareparts/busi_ngk.jpg',
            ],
            [
                'name' => 'Lampu Utama LED Philip Tyto M5 H6 AC/DC',
                'category' => 'Kelistrikan & Aki',
                'price' => 85000,
                'stock' => 25,
                'description' => 'Lampu depan LED hemat energi dengan pencahayaan putih fokus 6000K, cocok untuk semua tipe bebek dan matik.',
                'image_path' => 'spareparts/lampu_led.jpg',
            ],
            [
                'name' => 'Gear Set & Rantai SSS Gold 428-130L (VIXION/CB150R)',
                'category' => 'Transmisi & Rantai',
                'price' => 375000,
                'stock' => 10,
                'description' => 'Kit rantai & gir sprocket alumunium lapis emas SSS Racing. Kuat, presisi, serta menambah nilai estetika motor sport.',
                'image_path' => 'spareparts/gear_sss.jpg',
            ],
            [
                'name' => 'V-Belt Kit + Roller KTC Kytaco Vario 125/150',
                'category' => 'Transmisi & Rantai',
                'price' => 210000,
                'stock' => 22,
                'description' => 'Paket sabuk CVT EPDM tahan panas tinggi beserta roller berat presisi untuk akselerasi lebih halus tanpa slip.',
                'image_path' => 'spareparts/vbelt_ktc.jpg',
            ],
            [
                'name' => 'Filter Udara Honda Genuine Parts BeAT FI / Vario 110',
                'category' => 'Suku Cadang Mesin',
                'price' => 52000,
                'stock' => 60,
                'description' => 'Element comp air cleaner kertas berlapis oli, kotoran terperangkap sempurna tanpa menyumbat aliran udara ke throttle body.',
                'image_path' => 'spareparts/filter_hgp.jpg',
            ],
            [
                'name' => 'Filter Oli Ferrox Stainless Steel Universal',
                'category' => 'Suku Cadang Mesin',
                'price' => 185000,
                'stock' => 8,
                'description' => 'Filter oli berbahan mikro serat stainless steel 45 mikron, dapat dicuci dan digunakan kembali seumur hidup.',
                'image_path' => 'spareparts/filter_ferrox.jpg',
            ],
            [
                'name' => 'Coolant Radiator Seiken Super 1 Liter',
                'category' => 'Oli & Pelumas',
                'price' => 48000,
                'stock' => 30,
                'description' => 'Cairan pendingin radiator siap pakai berteknologi Anti-Rust & Anti-Boil untuk mencegah overheating pada sistem pendingin mesin.',
                'image_path' => 'spareparts/coolant.jpg',
            ],
        ];

        foreach ($spareparts as $data) {
            SparePart::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}

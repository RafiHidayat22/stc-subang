<?php
// database/seeders/ProgramCategorySeeder.php

namespace Database\Seeders;

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'               => 'Manufaktur & Produksi',
                'slug'               => 'manufaktur-produksi',
                'description'        => 'Pelatihan intensif untuk operasional pabrik dan lini produksi modern.',
                'description_long'   => 'Kategori ini mencakup seluruh program pelatihan yang berkaitan dengan operasional pabrik, manajemen lini produksi, pengendalian kualitas, serta penerapan metode kerja efisien berstandar industri global. Peserta akan dibekali kompetensi teknis yang langsung dapat diterapkan di dunia kerja.',
                'icon'               => 'precision_manufacturing',
                'duration'           => '5 Hari – 3 Bulan',
                'certification_body' => 'BNSP',
                'target_participant' => 'Operator, Teknisi, & Supervisor Muda',
                'price_display'      => 'Mulai Rp 2.500.000',
                'is_active'          => true,
                'order'              => 1,
            ],
            [
                'name'               => 'Kesehatan & Keselamatan Kerja (K3)',
                'slug'               => 'k3-hse',
                'description'        => 'Program K3 & HSE berstandar Kemnaker RI untuk semua level industri.',
                'description_long'   => 'Program pelatihan K3 STC dirancang untuk membentuk budaya keselamatan di tempat kerja. Dari awareness dasar hingga ahli K3 umum, semua program disertifikasi langsung oleh Kementerian Ketenagakerjaan RI dan mengacu pada peraturan perundangan K3 terkini.',
                'icon'               => 'health_and_safety',
                'duration'           => '3 – 12 Hari',
                'certification_body' => 'Kemnaker RI',
                'target_participant' => 'Semua Level – Operator hingga Manajer',
                'price_display'      => 'Mulai Rp 1.800.000',
                'is_active'          => true,
                'order'              => 2,
            ],
            [
                'name'               => 'Teknologi Otomotif',
                'slug'               => 'teknologi-otomotif',
                'description'        => 'Pelatihan teknisi otomotif konvensional, hybrid, dan kendaraan listrik (EV).',
                'description_long'   => 'Program otomotif STC mencakup teknologi kendaraan konvensional hingga elektrifikasi modern. Instruktur berpengalaman dari industri OEM memastikan peserta memahami sistem mesin, elektrikal, diagnostik, serta teknologi hybrid dan EV yang sedang berkembang pesat.',
                'icon'               => 'directions_car',
                'duration'           => '5 – 14 Hari',
                'certification_body' => 'BNSP / Kemnaker RI',
                'target_participant' => 'Teknisi & Mekanik Otomotif',
                'price_display'      => 'Mulai Rp 2.000.000',
                'is_active'          => true,
                'order'              => 3,
            ],
            [
                'name'               => 'Oil & Gas (MIGAS)',
                'slug'               => 'oil-gas-migas',
                'description'        => 'Sertifikasi tenaga teknik MIGAS sesuai standar Kementerian ESDM RI.',
                'description_long'   => 'Industri migas menuntut standar keselamatan tertinggi. Program STC di bidang ini mencakup well control, H2S safety, offshore operations, dan permit to work system. Semua program tersertifikasi Kementerian ESDM RI dan berstandar IWCF internasional.',
                'icon'               => 'oil_barrel',
                'duration'           => '5 – 10 Hari',
                'certification_body' => 'Kementerian ESDM RI',
                'target_participant' => 'Teknisi & Engineer MIGAS',
                'price_display'      => 'Mulai Rp 3.500.000',
                'is_active'          => true,
                'order'              => 4,
            ],
            [
                'name'               => 'Welding & Fabrikasi',
                'slug'               => 'welding-fabrikasi',
                'description'        => 'Sertifikasi welder internasional SMAW, MIG, TIG sesuai standar AWS & ASME.',
                'description_long'   => 'Program welding STC adalah salah satu yang paling komprehensif di Jawa Barat. Fasilitas workshop welding berstandar industri dan instruktur bersertifikat AWS memastikan peserta siap menghadapi uji kompetensi internasional dan langsung bekerja di industri.',
                'icon'               => 'hardware',
                'duration'           => '7 – 21 Hari',
                'certification_body' => 'BNSP / AWS',
                'target_participant' => 'Welder & Fabricator Industri',
                'price_display'      => 'Mulai Rp 3.000.000',
                'is_active'          => true,
                'order'              => 5,
            ],
            [
                'name'               => 'Listrik & Instrumentasi',
                'slug'               => 'listrik-instrumentasi',
                'description'        => 'Pelatihan teknisi listrik industri, PLC, SCADA, dan instrumentasi proses.',
                'description_long'   => 'Program ini dirancang untuk mencetak teknisi listrik dan instrumentasi industri yang handal. Mulai dari wiring dasar, panel control, hingga pemrograman PLC dan sistem SCADA yang banyak digunakan di industri manufaktur dan proses.',
                'icon'               => 'electrical_services',
                'duration'           => '5 – 14 Hari',
                'certification_body' => 'BNSP',
                'target_participant' => 'Teknisi Listrik & Instrumentasi',
                'price_display'      => 'Mulai Rp 2.800.000',
                'is_active'          => true,
                'order'              => 6,
            ],
        ];

        foreach ($categories as $cat) {
            ProgramCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ ProgramCategory seeded: ' . count($categories) . ' records.');
    }
}
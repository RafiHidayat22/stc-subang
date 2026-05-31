<?php
// database/seeders/CertificationCategorySeeder.php

namespace Database\Seeders;

use App\Models\CertificationCategory;
use Illuminate\Database\Seeder;

class CertificationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'         => 'Badan Nasional Sertifikasi Profesi (BNSP)',
                'slug'         => 'bnsp',
                'description'  => 'Pelatihan persiapan sertifikasi kompetensi profesi yang mengacu pada standar BNSP. Meningkatkan pengakuan kompetensi secara nasional, daya saing tenaga kerja, dan mendukung kebutuhan industri.',
                'logo'         => null,
                'badge_label'  => 'Nasional',
                'badge_icon'   => 'verified',
                'accent_color' => 'bg-primary',
                'cover_image'  => null,
                'is_active'    => true,
                'order'        => 1,
            ],
            [
                'name'         => 'Kementerian Ketenagakerjaan (KEMNAKER)',
                'slug'         => 'kemnaker',
                'description'  => 'Mendukung peningkatan kompetensi melalui pembinaan regulasi. Fokus pada kepatuhan K3, budaya keselamatan, dan standar operasional alat berat.',
                'logo'         => null,
                'badge_label'  => 'Regulasi',
                'badge_icon'   => 'gavel',
                'accent_color' => 'bg-safety-orange',
                'cover_image'  => null,
                'is_active'    => true,
                'order'        => 2,
            ],
            [
                'name'         => 'KPDM – Oil and Gas Explosives Technician',
                'slug'         => 'kpdm-oil-gas',
                'description'  => 'Sertifikasi khusus untuk teknisi bahan peledak di sektor minyak dan gas. Memastikan prosedur penanganan yang aman dan sesuai standar tinggi industri energi.',
                'logo'         => null,
                'badge_label'  => 'Spesialis',
                'badge_icon'   => 'oil_barrel',
                'accent_color' => 'bg-deep-slate',
                'cover_image'  => null,
                'is_active'    => true,
                'order'        => 3,
            ],
            [
                'name'         => 'Scaffolding, Working at Heights & Rigging',
                'slug'         => 'scaffolding-heights-rigging',
                'description'  => 'Program komprehensif dari LSP Promigas, Migas, dan K3 Nasional untuk mencegah kecelakaan kerja. Mencakup teknik instalasi, pengangkatan beban, dan prosedur keselamatan bekerja di ketinggian.',
                'logo'         => null,
                'badge_label'  => 'BNSP & Kemnaker',
                'badge_icon'   => 'construction',
                'accent_color' => 'bg-industrial-blue-light',
                'cover_image'  => null,
                'is_active'    => true,
                'order'        => 4,
            ],
        ];

        foreach ($categories as $cat) {
            CertificationCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ CertificationCategory seeded: ' . count($categories) . ' records.');
    }
}

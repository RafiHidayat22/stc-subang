<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Seed gallery dengan data dummy.
     *
     * Karena kita tidak dapat mengunduh gambar eksternal di semua environment,
     * seeder ini mendukung dua mode:
     *
     *  MODE A (default)  – menyimpan URL Unsplash sebagai path image.
     *                      Cocok untuk development di mana storage publik belum dipakai.
     *
     *  MODE B (download) – uncomment blok "Download & simpan ke storage" di bawah
     *                      untuk benar-benar mengunduh & menyimpan ke disk 'public'.
     */
    public function run(): void
    {
        $items = [
            [
                'caption'  => 'Safety First Training – Orientasi K3 Lapangan',
                'category' => 'K3',
                'order'    => 1,
                'url'      => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
            ],
            [
                'caption'  => 'Automotive Lab – Praktik Engine & Electrical',
                'category' => 'Automotive',
                'order'    => 2,
                'url'      => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&q=80',
            ],
            [
                'caption'  => 'Welding Certification – SMAW & TIG Practice',
                'category' => 'Welding',
                'order'    => 3,
                'url'      => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
            ],
            [
                'caption'  => 'Industrial Production – Operator Manufaktur',
                'category' => 'Manufaktur',
                'order'    => 4,
                'url'      => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
            ],
            [
                'caption'  => 'Oil & Gas Safety – H2S Awareness Training',
                'category' => 'MIGAS',
                'order'    => 5,
                'url'      => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&q=80',
            ],
            [
                'caption'  => 'Electrical & Instrumentation – PLC Workshop',
                'category' => 'Electrical',
                'order'    => 6,
                'url'      => 'https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=800&q=80',
            ],
            [
                'caption'  => 'Uji Kompetensi BNSP – Asesmen Peserta',
                'category' => 'Sertifikasi',
                'order'    => 7,
                'url'      => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80',
            ],
            [
                'caption'  => 'Wisuda Alumni STC Angkatan 2023',
                'category' => 'Event',
                'order'    => 8,
                'url'      => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80',
            ],
        ];

        foreach ($items as $item) {
            // ─────────────────────────────────────────────────────────
            // MODE A: simpan URL sebagai path (tanpa unduh file).
            // Ganti bagian ini dengan MODE B jika ingin unduh ke storage.
            // ─────────────────────────────────────────────────────────
            $imagePath = $item['url'];

            /*
            // ─────────────────────────────────────────────────────────
            // MODE B: Download & simpan ke disk 'public' (aktifkan jika perlu)
            // ─────────────────────────────────────────────────────────
            try {
                $contents  = file_get_contents($item['url']);
                $filename  = 'gallery/' . Str::uuid() . '.jpg';
                Storage::disk('public')->put($filename, $contents);
                $imagePath = $filename;
            } catch (\Exception $e) {
                // Fallback ke URL jika gagal
                $imagePath = $item['url'];
            }
            */

            Gallery::create([
                'caption'   => $item['caption'],
                'image'     => $imagePath,
                'category'  => $item['category'],
                'is_active' => true,
                'order'     => $item['order'],
            ]);
        }

        $this->command->info('✅  GallerySeeder: ' . count($items) . ' item berhasil di-seed.');
    }
}
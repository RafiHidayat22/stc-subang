<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ─────────────────────────────────────────────────────
        $categories = [
            ['name' => 'Industri',        'slug' => 'industri',        'color' => 'bg-industrial-blue-light', 'sort_order' => 1],
            ['name' => 'Safety (K3)',      'slug' => 'safety-k3',       'color' => 'bg-safety-orange',         'sort_order' => 2],
            ['name' => 'Sertifikasi BNSP', 'slug' => 'sertifikasi-bnsp','color' => 'bg-green-600',             'sort_order' => 3],
            ['name' => 'Tips Karir',       'slug' => 'tips-karir',      'color' => 'bg-secondary',             'sort_order' => 4],
            ['name' => 'Event',            'slug' => 'event',           'color' => 'bg-primary',               'sort_order' => 5],
        ];

        foreach ($categories as $cat) {
            ArticleCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $cat = ArticleCategory::pluck('id', 'slug');

        // ── Articles ───────────────────────────────────────────────────────
        $articles = [
            [
                'article_category_id' => $cat['sertifikasi-bnsp'],
                'title'               => 'Pentingnya Sertifikasi BNSP bagi Tenaga Kerja di Sektor Minyak & Gas',
                'slug'                => 'pentingnya-sertifikasi-bnsp-migas',
                'excerpt'             => 'Menghadapi persaingan global, tenaga kerja Indonesia diwajibkan memiliki kompetensi yang terstandarisasi. Pelajari bagaimana STC Subang membantu percepatan karir melalui sertifikasi BNSP yang diakui secara nasional maupun internasional.',
                'body'                => $this->articleBodyBnsp(),
                'thumbnail'           => null,
                'featured_image'      => null,
                'author_name'         => 'Redaksi STC Indonesia',
                'author_role'         => 'Industrial Specialist & Trainer',
                'tags'                => ['#IndustrialTraining', '#SertifikasiBNSP', '#STCIndonesia', '#SafetyFirst'],
                'is_featured'         => true,
                'is_published'        => true,
                'views'               => 1280,
                'published_at'        => now()->subDays(18),
            ],
            [
                'article_category_id' => $cat['safety-k3'],
                'title'               => 'Implementasi Safety Culture di Lingkungan Workshop Otomotif',
                'slug'                => 'implementasi-safety-culture-workshop-otomotif',
                'excerpt'             => 'Membangun budaya keselamatan kerja bukan hanya soal regulasi, tapi juga kesadaran kolektif. Berikut adalah langkah praktis penerapan K3 di lingkungan workshop otomotif.',
                'body'                => '<p>Artikel lengkap tentang safety culture di workshop otomotif...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 874,
                'published_at'        => now()->subDays(22),
                'tags'                => ['#K3', '#SafetyCulture', '#Otomotif'],
            ],
            [
                'article_category_id' => $cat['industri'],
                'title'               => 'Teknologi Terbaru dalam Maintenance Pembangkit Listrik',
                'slug'                => 'teknologi-maintenance-pembangkit-listrik',
                'excerpt'             => 'Evolusi pemeliharaan prediktif menggunakan sensor IoT kini menjadi standar baru di industri power generation. Simak ulasan lengkapnya.',
                'body'                => '<p>Artikel lengkap tentang teknologi maintenance pembangkit listrik...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 612,
                'published_at'        => now()->subDays(25),
                'tags'                => ['#Industri', '#IoT', '#PowerGeneration'],
            ],
            [
                'article_category_id' => $cat['tips-karir'],
                'title'               => 'Cara Mempersiapkan Diri Menghadapi Uji Kompetensi LSP',
                'slug'                => 'cara-mempersiapkan-uji-kompetensi-lsp',
                'excerpt'             => 'Banyak peserta gagal bukan karena tidak mampu, tapi kurang persiapan dokumen. Pelajari checklist wajib sebelum mengikuti asesmen.',
                'body'                => '<p>Artikel lengkap tentang persiapan uji kompetensi LSP...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 543,
                'published_at'        => now()->subDays(30),
                'tags'                => ['#TipsKarir', '#UjiKompetensi', '#LSP'],
            ],
            [
                'article_category_id' => $cat['sertifikasi-bnsp'],
                'title'               => 'Daftar Skema Sertifikasi Terbaru Tahun 2024 di STC Indonesia',
                'slug'                => 'skema-sertifikasi-terbaru-2024',
                'excerpt'             => 'Kami memperluas jangkauan skema sertifikasi untuk bidang logistik dan supply chain. Cek daftar lengkapnya di sini.',
                'body'                => '<p>Artikel lengkap tentang skema sertifikasi terbaru 2024...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 388,
                'published_at'        => now()->subDays(35),
                'tags'                => ['#SertifikasiBNSP', '#Logistik', '#SupplyChain'],
            ],
            [
                'article_category_id' => $cat['event'],
                'title'               => 'Dokumentasi Sertifikasi Batch April 2024',
                'slug'                => 'dokumentasi-sertifikasi-batch-april-2024',
                'excerpt'             => 'Melihat antusiasme para peserta dalam menuntaskan uji kompetensi praktik batch April 2024.',
                'body'                => '<p>Artikel lengkap tentang dokumentasi sertifikasi batch April 2024...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 251,
                'published_at'        => now()->subDays(40),
                'tags'                => ['#Event', '#Sertifikasi', '#Batch'],
            ],
            [
                'article_category_id' => $cat['safety-k3'],
                'title'               => 'Panduan Memilih Skema Sertifikasi BNSP yang Tepat',
                'slug'                => 'panduan-memilih-skema-sertifikasi-bnsp',
                'excerpt'             => 'Pahami perbedaan berbagai skema sertifikasi agar sesuai dengan jalur karir Anda di industri.',
                'body'                => '<p>Artikel lengkap tentang panduan memilih skema sertifikasi BNSP...</p>',
                'thumbnail'           => null,
                'is_featured'         => false,
                'is_published'        => true,
                'views'               => 198,
                'published_at'        => now()->subDays(45),
                'tags'                => ['#BNSP', '#TipsKarir'],
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }

    private function articleBodyBnsp(): string
    {
        return <<<'HTML'
<p>
    Di era persaingan industri global yang semakin ketat, memiliki keahlian teknis saja tidak lagi cukup. Tenaga kerja di sektor Oil &amp; Gas, Otomotif, dan Pembangkit Listrik kini dituntut untuk membuktikan kapabilitas mereka melalui standar yang diakui secara nasional maupun internasional.
</p>

<h2>Membangun Kepercayaan dengan Sertifikasi</h2>
<p>
    Sertifikasi profesi, khususnya yang dikeluarkan oleh Badan Nasional Sertifikasi Profesi (BNSP), berfungsi sebagai pengakuan formal atas kompetensi seseorang. Bagi perusahaan, mempekerjakan tenaga kerja bersertifikat berarti memitigasi risiko operasional dan menjamin kualitas output kerja yang sesuai dengan prosedur keselamatan (K3).
</p>

<blockquote>
    "Sertifikasi bukan sekadar selembar kertas, melainkan bukti nyata dari dedikasi seorang profesional terhadap standar keamanan dan efisiensi industri."
</blockquote>

<h3>Manfaat Utama Mengikuti Training STC:</h3>
<ul>
    <li><strong>Peningkatan Kredibilitas:</strong> Profil profesional Anda akan lebih menonjol di mata rekruter dan klien industri besar.</li>
    <li><strong>Kepatuhan Regulasi:</strong> Memastikan setiap tindakan di lapangan sesuai dengan standar keamanan industri terbaru.</li>
    <li><strong>Akselerasi Karir:</strong> Membuka peluang untuk promosi ke posisi manajerial atau supervisi dengan sertifikasi yang relevan.</li>
</ul>

<p>
    Subang Training Center (STC Indonesia) berkomitmen untuk menyediakan kurikulum pelatihan yang praktis dan berbasis data. Dengan instruktur yang telah berpengalaman puluhan tahun di lapangan, kami memastikan setiap peserta tidak hanya lulus ujian sertifikasi, tetapi benar-benar menguasai materi secara aplikatif.
</p>
HTML;
    }
}
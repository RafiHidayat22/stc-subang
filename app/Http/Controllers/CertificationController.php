<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\CertificationCategory;
use App\Models\CertificationItem;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Halaman utama sertifikasi (index).
     * URL: /certification
     */
    public function index()
    {
        $categories = CertificationCategory::with(['items' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Akreditasi/logo yang tampil di home (dipakai juga di hero section)
        $certifications = Certification::active()->orderBy('order')->get();

        return view('certification.index', compact('categories', 'certifications'));
    }

    /**
     * Halaman kategori sertifikasi.
     * URL: /certification/category/{slug}
     */
    public function category(CertificationCategory $category)
    {
        $category->load(['items' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }]);

        // Semua kategori untuk sidebar/navigation
        $allCategories = CertificationCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('category_certification.index', compact('category', 'allCategories'));
    }

    /**
     * Halaman detail satu item sertifikasi.
     * URL: /certification/{certificationItem:slug}
     */
    public function show(CertificationItem $certificationItem)
    {
        $certificationItem->load('category');

        // Related items dari kategori yang sama
        $relatedItems = CertificationItem::where('certification_category_id', $certificationItem->certification_category_id)
            ->where('id', '!=', $certificationItem->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->take(3)
            ->get();

        return view('detail_certification.index', [
            'item'         => $certificationItem,
            'relatedItems' => $relatedItems,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Gallery;
use App\Models\Certification;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        // Each returns empty collection when table has no data yet —
        // the Blade view falls back to dummy data in @empty blocks.

        $programs = Program::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('order')
            ->limit(6)
            ->get();

        $galleries = Gallery::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(8)
            ->get();

        $certifications = Certification::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->limit(3)
            ->get();

        return view('home.index', [
            'programs'       => $programs,
            'galleries'      => $galleries,
            'certifications' => $certifications,
            'testimonials'   => $testimonials,
            'meta_title'     => 'STC Indonesia | Subang Training Center – Professional Industrial Training',
            'meta_description' => 'Pusat pelatihan industri berbasis kompetensi. Program bersertifikasi BNSP & Kemnaker RI untuk manufaktur, otomotif, migas, K3, welding, dan listrik.',
        ]);
    }
}

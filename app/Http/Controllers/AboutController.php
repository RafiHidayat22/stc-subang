<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the About page.
     */
    public function index(): View
    {
        // Certifications — falls back to dummy data in @empty block
        $certifications = Certification::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Instructors — optional; if you don't have an Instructor model yet,
        // the view falls back to dummy cards via @forelse ... @empty
        $instructors = [];
        if (class_exists(\App\Models\Instructor::class)) {
            $instructors = \App\Models\Instructor::query()
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        return view('about.index', [
            'certifications' => $certifications,
            'instructors'    => $instructors,
            'meta_title'     => 'Tentang Kami | STC Indonesia – Subang Training Center',
            'meta_description' => 'Pelajari profil, visi, misi, dan nilai perusahaan Subang Training Center (STC Indonesia) — pusat pelatihan industri berbasis kompetensi di Jawa Barat.',
        ]);
    }
}
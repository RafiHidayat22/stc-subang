<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailGalleryController extends Controller
{
    /**
     * Gallery detail page — shows all active photos for a given category.
     *
     * Route: /gallery/{category}
     * Name:  gallery.detail
     *
     * If the category slug is "all", every active photo is returned
     * (useful for a "view all" deep-link). Unknown categories that have
     * no photos will still render the page with an empty state rather
     * than a 404, keeping the UX graceful.
     */
    public function index(string $category)
    {
        // Decode URL-encoded slugs (e.g. "K3%20Umum" → "K3 Umum")
        $categoryDecoded = urldecode($category);

        $query = Gallery::active()
            ->orderBy('order')
            ->orderByDesc('created_at');

        // "all" is a reserved slug meaning every active photo
        if ($categoryDecoded !== 'all') {
            $query->where('category', $categoryDecoded);
        }

        $photos = $query->get();

        // All unique categories (for the sidebar / filter pills)
        $categories = Gallery::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Stat — total photos in this view
        $totalAll = Gallery::active()->count();

        return view('detail_gallery.index', compact(
            'photos',
            'categories',
            'categoryDecoded',
            'totalAll',
        ));
    }
}
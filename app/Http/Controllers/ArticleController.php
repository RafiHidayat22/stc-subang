<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * GET /articles
     *
     * Renders the article index page with:
     *  - the featured (hero) article
     *  - all categories with their published-article counts
     *  - a paginated grid of published articles (optionally filtered by category)
     */
    public function index(Request $request)
    {
        // ── Featured article (shown as full-width hero card) ───────────────
        $featured = Article::published()
            ->featured()
            ->with('category')
            ->latest('published_at')
            ->first();

        // ── Categories for the sidebar filter ─────────────────────────────
        $categories = ArticleCategory::orderBy('sort_order')
            ->withCount(['articles as articles_count' => fn ($q) => $q->published()])
            ->get();

        // Total published articles (for "Semua" button count)
        $totalPublished = Article::published()->count();

        // ── Articles grid (excludes the featured article) ──────────────────
        $query = Article::published()
            ->with('category')
            ->latest('published_at');

        // Exclude the featured article from the grid to avoid duplication
        if ($featured) {
            $query->where('id', '!=', $featured->id);
        }

        // Category filter via ?category={slug}
        $activeCategory = null;
        if ($request->filled('category')) {
            $activeCategory = ArticleCategory::where('slug', $request->category)->firstOrFail();
            $query->where('article_category_id', $activeCategory->id);
        }

        $articles = $query->paginate(6)->withQueryString();

        return view('articles.index', compact(
            'featured',
            'categories',
            'totalPublished',
            'activeCategory',
            'articles',
        ));
    }

    /**
     * GET /articles/{article:slug}
     *
     * Renders the detail page for a single published article.
     */
    public function show(Article $article)
    {
        // Only show published articles to the public
        abort_unless($article->is_published, 404);

        // Increment view counter
        $article->incrementViews();

        // ── Related articles ───────────────────────────────────────────────
        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where(function ($q) use ($article) {
                if ($article->article_category_id) {
                    $q->where('article_category_id', $article->article_category_id);
                }
            })
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        // ── Sidebar: trending articles (most viewed) ───────────────────────
        $trending = Article::published()
            ->where('id', '!=', $article->id)
            ->with('category')
            ->orderByDesc('views')
            ->take(4)
            ->get();

        // ── Load category eagerly ──────────────────────────────────────────
        $article->load('category');

        return view('articles.show', compact('article', 'related', 'trending'));
    }
}
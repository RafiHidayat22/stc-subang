<?php
// app/Http/Controllers/ProgramController.php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Program index – show all program categories.
     * Route: GET /programs
     */
    public function index(Request $request)
    {
        $categories = ProgramCategory::active()
            ->withCount('programs')
            ->orderBy('order')
            ->get();

        return view('program.index', compact('categories'));
    }

    /**
     * Category page – list all programs inside a category.
     * Route: GET /programs/category/{category:slug}
     */
    public function category(Request $request, ProgramCategory $category)
    {
        $programs = Program::active()
            ->where('category_id', $category->id)
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->paginate(9);

        $otherCategories = ProgramCategory::active()
            ->orderBy('order')
            ->get();

        return view('category_program.index', compact(
            'category',
            'programs',
            'otherCategories'
        ));
    }

    /**
     * Program detail page.
     * Route: GET /programs/{program:slug}
     */
    public function show(Program $program)
    {
        $program->load('category');

        $relatedPrograms = Program::active()
            ->where('id', '!=', $program->id)
            ->where('category_id', $program->category_id)
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->take(3)
            ->get();

        return view('detail_program.index', compact(
            'program',
            'relatedPrograms'
        ));
    }

    
}
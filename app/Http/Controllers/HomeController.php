<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;

class HomeController extends Controller
{
    public function index()
    {
        $featuredGuides = Guide::published()
            ->with(['category', 'author'])
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();

        $categories = Category::withCount(['guides' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        $recentGuides = Guide::published()
            ->with(['category', 'author'])
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredGuides', 'categories', 'recentGuides'));
    }
}

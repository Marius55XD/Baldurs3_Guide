<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_guides'     => Guide::count(),
            'published_guides' => Guide::where('status', 'published')->count(),
            'draft_guides'     => Guide::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'total_views'      => Guide::sum('views'),
        ];

        $recentGuides = Guide::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentGuides'));
    }
}

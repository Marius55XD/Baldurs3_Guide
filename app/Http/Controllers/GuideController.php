<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $query = Guide::published()->with(['category', 'author']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        $guides = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();
        $user = $request->user();
        $purchasedGuideIds = collect();

        if ($user) {
            $purchasedGuideIds = $user->guidePurchases()->pluck('guide_id');
        }

        return view('guides.index', compact('guides', 'categories', 'purchasedGuideIds'));
    }

    public function show(string $slug)
    {
        $guide = Guide::published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $guide->incrementViews();

        $related = Guide::published()
            ->where('category_id', $guide->category_id)
            ->where('id', '!=', $guide->id)
            ->latest()
            ->take(3)
            ->get();

        $user = request()->user();
        $hasFullAccess = false;
        $hasPurchased = false;

        if ($user) {
            $hasPurchased = $user->hasPurchasedGuide($guide);
            $hasFullAccess = $user->isEditor()
                || $user->id === $guide->user_id
                || $hasPurchased;
        }

        $previewContent = $hasFullAccess ? null : Str::words($guide->content, 55, '...');

        return view('guides.show', compact('guide', 'related', 'hasFullAccess', 'hasPurchased', 'previewContent'));
    }
}

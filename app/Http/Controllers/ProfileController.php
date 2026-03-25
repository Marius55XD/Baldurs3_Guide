<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $user->load(['guides' => function ($query) {
            $query->with('category')->latest()->take(5);
        }]);

        $guideCount = $user->guides()->count();
        $publishedCount = $user->guides()->where('status', 'published')->count();
        $totalViews = (int) $user->guides()->sum('views');

        $recentActivity = $user->guides
            ->take(3)
            ->map(function ($guide) {
                $isUpdated = $guide->updated_at && $guide->updated_at->gt($guide->created_at->addMinute());

                return [
                    'text' => $isUpdated
                        ? 'You updated your guide "' . $guide->title . '".'
                        : 'You published a new guide: "' . $guide->title . '".',
                    'time' => $guide->updated_at?->diffForHumans() ?? $guide->created_at?->diffForHumans(),
                ];
            })
            ->values();

        return view('profile.show', [
            'user' => $user,
            'guideCount' => $guideCount,
            'publishedCount' => $publishedCount,
            'totalViews' => $totalViews,
            'recentActivity' => $recentActivity,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile details updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $avatarFile = $validated['avatar'];
        $avatarDir = public_path('images/avatars');

        if (! is_dir($avatarDir)) {
            mkdir($avatarDir, 0755, true);
        }

        if (! empty($user->avatar)) {
            $oldAvatarPath = public_path($user->avatar);
            if (is_file($oldAvatarPath)) {
                @unlink($oldAvatarPath);
            }
        }

        $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
        $avatarFile->move($avatarDir, $fileName);

        $user->update([
            'avatar' => 'images/avatars/' . $fileName,
        ]);

        return back()->with('success', 'Profile image updated successfully.');
    }
}

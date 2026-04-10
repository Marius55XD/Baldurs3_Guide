<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403, 'Unauthorized. Admin access required.');
    }

    private function storeFeaturedImage(Request $request, ?Guide $guide = null): ?string
    {
        if (! $request->hasFile('featured_image')) {
            return $guide?->featured_image;
        }

        $featuredImage = $request->file('featured_image');
        $featuredImageDir = public_path('images/guides');

        if (! is_dir($featuredImageDir)) {
            mkdir($featuredImageDir, 0755, true);
        }

        if ($guide && ! empty($guide->featured_image)) {
            $oldFeaturedImagePath = public_path($guide->featured_image);
            if (is_file($oldFeaturedImagePath)) {
                @unlink($oldFeaturedImagePath);
            }
        }

        $fileName = 'guide_' . ($guide?->id ?? 'new') . '_' . time() . '.' . $featuredImage->getClientOriginalExtension();
        $featuredImage->move($featuredImageDir, $fileName);

        return 'images/guides/' . $fileName;
    }

    public function index()
    {
        $guides = Guide::with(['category', 'author'])->latest()->paginate(15);
        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.guides.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['required', 'string'],
            'excerpt'         => ['nullable', 'string', 'max:500'],
            'category_id'     => ['required', 'exists:categories,id'],
            'status'          => ['required', 'in:draft,published'],
            'featured_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'tags'            => ['nullable', 'array'],
            'tags.*'          => ['exists:tags,id'],
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);

        // Ensure slug uniqueness
        $originalSlug = $data['slug'];
        $count = 1;
        while (Guide::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count++;
        }

        $data['featured_image'] = $this->storeFeaturedImage($request);

        $guide = Guide::create($data);

        if ($request->filled('tags')) {
            $guide->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide created successfully.');
    }

    public function edit(Guide $guide)
    {
        $this->ensureAdmin();

        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.guides.edit', compact('guide', 'categories', 'tags'));
    }

    public function update(Request $request, Guide $guide)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['required', 'string'],
            'excerpt'         => ['nullable', 'string', 'max:500'],
            'category_id'     => ['required', 'exists:categories,id'],
            'status'          => ['required', 'in:draft,published'],
            'featured_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'tags'            => ['nullable', 'array'],
            'tags.*'          => ['exists:tags,id'],
        ]);

        // Re-slug only if title changed
        if ($guide->title !== $data['title']) {
            $slug = Str::slug($data['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Guide::where('slug', $slug)->where('id', '!=', $guide->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        }

        $data['featured_image'] = $this->storeFeaturedImage($request, $guide);

        $guide->update($data);
        $guide->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy(Guide $guide)
    {
        $this->ensureAdmin();

        if (! empty($guide->featured_image)) {
            $featuredImagePath = public_path($guide->featured_image);
            if (is_file($featuredImagePath)) {
                @unlink($featuredImagePath);
            }
        }

        $guide->delete();
        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide deleted.');
    }
}

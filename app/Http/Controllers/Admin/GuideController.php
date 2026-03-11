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
    public function index()
    {
        $guides = Guide::with(['category', 'author'])->latest()->paginate(15);
        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.guides.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['required', 'string'],
            'excerpt'         => ['nullable', 'string', 'max:500'],
            'category_id'     => ['required', 'exists:categories,id'],
            'status'          => ['required', 'in:draft,published'],
            'featured_image'  => ['nullable', 'url', 'max:2048'],
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

        $guide = Guide::create($data);

        if ($request->filled('tags')) {
            $guide->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide created successfully.');
    }

    public function edit(Guide $guide)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.guides.edit', compact('guide', 'categories', 'tags'));
    }

    public function update(Request $request, Guide $guide)
    {
        $data = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['required', 'string'],
            'excerpt'         => ['nullable', 'string', 'max:500'],
            'category_id'     => ['required', 'exists:categories,id'],
            'status'          => ['required', 'in:draft,published'],
            'featured_image'  => ['nullable', 'url', 'max:2048'],
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

        $guide->update($data);
        $guide->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide deleted.');
    }
}

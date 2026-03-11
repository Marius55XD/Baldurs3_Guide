@extends('layouts.admin')
@section('title', 'Edit Guide')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="bg3-card p-4">
            <form action="{{ route('admin.guides.update', $guide) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $guide->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $guide->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft" @selected(old('status', $guide->status) === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $guide->status) === 'published')>Published</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $guide->excerpt) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="16" required>{{ old('content', $guide->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Featured Image / GIF URL</label>
                        <input type="url" name="featured_image" class="form-control"
                               value="{{ old('featured_image', $guide->featured_image) }}" placeholder="https://example.com/image.jpg">
                        <small style="color:#d8ebff;">Paste a direct image link (.jpg, .png, .webp, .gif).</small>
                    </div>

                    @if($tags->count())
                    <div class="col-12">
                        <label class="form-label">Tags</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]"
                                       value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                       @if(in_array($tag->id, old('tags', $guide->tags->pluck('id')->toArray()))) checked @endif>
                                <label class="form-check-label" for="tag_{{ $tag->id }}" style="color:#d8ebff;">{{ $tag->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                            <i class="bi bi-eye me-1"></i>Preview
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-gold px-5">
                                <i class="bi bi-check2 me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


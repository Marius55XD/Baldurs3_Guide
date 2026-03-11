@extends('layouts.admin')
@section('title', 'Create Guide')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="bg3-card p-4">
            <form action="{{ route('admin.guides.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select categoryâ€¦</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                            <option value="published" @selected(old('status') === 'published')>Published</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Excerpt <small style="color:#d8ebff;">(auto-generated if blank)</small></label>
                        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="16" required>{{ old('content') }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small style="color:#d8ebff;">Use plain text. Paragraphs and line breaks are preserved.</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Featured Image / GIF URL</label>
                        <input type="url" name="featured_image" class="form-control"
                               value="{{ old('featured_image') }}" placeholder="https://example.com/image.jpg">
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
                                       @if(in_array($tag->id, old('tags', []))) checked @endif>
                                <label class="form-check-label" for="tag_{{ $tag->id }}" style="color:#d8ebff;">{{ $tag->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-gold px-5">
                            <i class="bi bi-check2 me-2"></i>Create Guide
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


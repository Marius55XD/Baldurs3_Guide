@extends('layouts.admin')
@section('title', 'Edit Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="bg3-card p-4">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $category->name) }}" required autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon / Emoji</label>
                    <input type="text" name="icon" class="form-control"
                           value="{{ old('icon', $category->icon) }}" placeholder="e.g. ⚔️">
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-gold px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

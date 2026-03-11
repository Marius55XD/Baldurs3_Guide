@extends('layouts.admin')
@section('title', 'Manage Categories')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>New Category
    </a>
</div>

<div class="bg3-card p-0 overflow-hidden">
    <table class="table table-dark-bg table-hover mb-0">
        <thead>
            <tr>
                <th class="ps-4">Name</th>
                <th>Slug</th>
                <th>Icon</th>
                <th>Description</th>
                <th>Guides</th>
                <th class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td class="ps-4 fw-semibold text-dark">{{ $category->name }}</td>
                <td><code style="color:#d8ebff;">{{ $category->slug }}</code></td>
                <td>{{ $category->icon }}</td>
                <td><small>{{ Str::limit($category->description, 60) }}</small></td>
                <td>{{ $category->guides_count }}</td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-gold me-1">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete category? All guides in it will also be deleted.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-dark">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


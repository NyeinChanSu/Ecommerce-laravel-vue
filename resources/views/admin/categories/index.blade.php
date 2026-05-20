@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h4 mb-0">Categories</h1>
            <p class="mb-0 text-muted">Manage product categories.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>
    <div class="card-body">
        @if($categories->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parent?->name ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                                <form action="{{ route('admin.categories.moveUp', $category) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary">↑</button>
                                </form>
                                <form action="{{ route('admin.categories.moveDown', $category) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary">↓</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        @else
            <div class="alert alert-info">No categories yet.</div>
        @endif
    </div>
</div>
@endsection

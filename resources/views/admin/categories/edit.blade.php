@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h1 class="h4 mb-0">Edit Category</h1>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ (old('parent_id', $category->parent_id) == $p->id) ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
                <button class="btn btn-primary">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection

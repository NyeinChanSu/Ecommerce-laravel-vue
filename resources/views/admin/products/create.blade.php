@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h1 class="h4 mb-0">Add New Product</h1>
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

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="row gy-3">
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" required>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Images (comma separated URLs)</label>
                <input type="text" class="form-control" name="images" value="{{ old('images') }}">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
                <button type="submit" class="btn btn-success">Create Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
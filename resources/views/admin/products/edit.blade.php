@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h1 class="h4 mb-0">Edit Product</h1>
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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug', $product->slug) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="row gy-3">
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            @if(!empty($product->images) && is_array($product->images))
                <div class="mb-3">
                    <label class="form-label mt-3">Product Image</label>
                    <div id="existing_images_container" class="d-flex flex-wrap gap-3">
                        @foreach($product->images as $img)
                            @php
                                $imgUrl = preg_match('#^https?://#i', $img) ? $img : asset('storage/' . $img);
                            @endphp
                            <div class="existing-image-item position-relative" data-image="{{ $img }}" style="width:120px;">
                                <img src="{{ $imgUrl }}" alt="" style="width:120px; height:auto; display:block;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 existing-image-remove">×</button>
                            </div>
                        @endforeach
                    </div>
                    <div id="existing_images_inputs"></div>
                </div>
            @endif

            <div class="mb-3 mt-3">
                <label class="form-label">Upload Image</label>
                <input type="file" class="form-control" name="images_files[]" id="images_files" multiple>
                <div id="images_preview" class="d-flex flex-wrap gap-3 mt-3"></div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('images_files');
    const preview = document.getElementById('images_preview');
    const dt = new DataTransfer();

    function render() {
        preview.innerHTML = '';
        for (let i = 0; i < dt.files.length; i++) {
            const file = dt.files[i];
            const url = URL.createObjectURL(file);
            const wrapper = document.createElement('div');
            wrapper.style.width = '120px';
            wrapper.className = 'text-center';

            const img = document.createElement('img');
            img.src = url;
            img.style.width = '120px';
            img.style.height = 'auto';
            img.style.display = 'block';
            img.style.marginBottom = '6px';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-sm btn-outline-danger';
            btn.textContent = 'Remove';
            btn.addEventListener('click', function () {
                const newDt = new DataTransfer();
                for (let j = 0; j < dt.files.length; j++) {
                    if (j === i) continue;
                    newDt.items.add(dt.files[j]);
                }
                while (dt.files.length) dt.items.remove(0);
                for (let k = 0; k < newDt.files.length; k++) dt.items.add(newDt.files[k]);
                input.files = dt.files;
                render();
            });

            wrapper.appendChild(img);
            wrapper.appendChild(btn);
            preview.appendChild(wrapper);
        }
    }

    function fileExistsInDt(file) {
        for (let j = 0; j < dt.files.length; j++) {
            if (dt.files[j].name === file.name && dt.files[j].size === file.size) return true;
        }
        return false;
    }

    input.addEventListener('change', function (e) {
        for (let i = 0; i < input.files.length; i++) {
            const f = input.files[i];
            if (!fileExistsInDt(f)) dt.items.add(f);
        }
        input.files = dt.files;
        render();
    });

    const existingImagesContainer = document.getElementById('existing_images_container');
    const existingImagesInputs = document.getElementById('existing_images_inputs');
    if (existingImagesContainer && existingImagesInputs) {
        existingImagesContainer.querySelectorAll('.existing-image-remove').forEach(button => {
            button.addEventListener('click', function () {
                const wrapper = this.closest('.existing-image-item');
                if (!wrapper) return;
                const imagePath = wrapper.dataset.image;

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'remove_images[]';
                hidden.value = imagePath;
                existingImagesInputs.appendChild(hidden);

                wrapper.remove();
            });
        });
    }
});
</script>
@endpush
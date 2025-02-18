@php
    $route = 'admin.shop.sub-categories.';
@endphp

<form action="{{ isset($subCategory) ? route( $route . 'update', $subCategory->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($subCategory))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="categories" class="form-label">Category</label>
        <select name="categories" id="" class="form-select select2">
            <option value="">Select value</option>
            @php
                $selectedCategories = old('categories', $subCategory?->categories?->pluck('id')->toArray() ?? []);
                if (!isset($subCategory)) {
                    $selectedCategories = old('categories', []);
                }
            @endphp
            @foreach($categories as $key => $category)
                <option
                    {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}
                    value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('categories')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control @error('name')is-invalid @enderror" value="{{ old('name', $subCategory->name ?? '') }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="" class="form-control text-editor @error('description')is-invalid @enderror">{!! old('description', $subCategory->description ?? '') !!}</textarea>
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image Banner</label>
        <input type="file" name="image" id="" class="form-control @error('image')is-invalid @enderror" value="{{ old('image', $subCategory->image ?? '') }}">
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($subCategory->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($subCategory) ? 'Update' : 'Create' }} Sub Category</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

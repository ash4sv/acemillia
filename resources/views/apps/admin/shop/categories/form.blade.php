@php
    $route = 'admin.shop.categories.';
@endphp

<form action="{{ isset($category) ? route( $route . 'update', $category->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control @error('name')is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="" class="form-control text-editor @error('description')is-invalid @enderror">{!! old('description', $category->description ?? '') !!}</textarea>
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image Banner</label>
        <input type="file" name="image" id="" class="form-control @error('image')is-invalid @enderror" value="{{ old('image', $category->image ?? '') }}">
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($category->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Create' }} Category</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

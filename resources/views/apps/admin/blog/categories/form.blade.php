@php
    $route = 'admin.blog.categories.';
@endphp

<form id="modal-form" action="{{ isset($postCategory) ? route( $route . 'update', $postCategory->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($postCategory))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control @error('name')is-invalid @enderror" value="{{ old('name', $postCategory->name ?? '') }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="" class="form-control text-editor @error('description')is-invalid @enderror">{!! old('description', $postCategory->description ?? '') !!}</textarea>
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image Banner</label>
        <input type="file" name="image" id="" class="form-control @error('image')is-invalid @enderror" value="{{ old('image', $postCategory->image ?? '') }}">
        @if(isset($postCategory) && $postCategory->image)
            <img src="{{ asset($postCategory->image) }}" alt="Single Image" style="max-width: 150px; margin-top: 10px;">
        @endif
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($postCategory->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($postCategory) ? 'Update' : 'Create' }} Post Category</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

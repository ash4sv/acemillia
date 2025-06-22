@php
    $route = 'admin.carousel-slider.';
@endphp

<form id="modal-form" action="{{ isset($carousel) ? route( $route . 'update', $carousel->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($carousel))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="" class="form-control" value="{{ old('image', $carousel->image ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="url" class="form-label">Image URL</label>
        <select name="url" id="url" class="form-select select2">
            <option value=""></option>
            @foreach($routes as $route)
                <option value="{{ $route['url'] }}"
                    {{ (isset($carousel) && $carousel->url == $route['url']) ? 'selected' : '' }}>
                    {{ $route['url'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($carousel->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($carousel) ? 'Update' : 'Create' }} Carousel Slider</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

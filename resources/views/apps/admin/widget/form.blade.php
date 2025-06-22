@php
    $route = 'admin.widget.';
@endphp

<form id="modal-form" action="{{ isset($widget) ? route( $route . 'update', $widget->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($widget))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control" value="{{ old('name', $widget->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <select name="size" id="size" class="form-select select2">
            <option value="{{ null }}">Please select size</option>
            @foreach($widgetSizes as $size)
                <option value="{{ $size['data'] }}" {{ (old('size', $widget->size ?? '') == $size['data']) ? 'selected' : '' }}>
                    {{ $size['name'] . ' - ' . $size['data'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="" class="form-control" value="{{ old('image', $widget->image ?? '') }}">
        @if(isset($widget))
            <a href="{{ asset($widget->image) }}">{{ $widget->image }}</a>
        @endif
    </div>

    <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="text" name="url" id="" class="form-control" value="{{ old('url', $widget->url ?? '') }}">
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="start_at" class="form-label">Start at</label>
                <input type="text" name="start_at" id="" class="form-control flatpickr-start" value="{{ old('start_at', $widget->start_at ?? '') }}">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="end_at" class="form-label">End at</label>
                <input type="text" name="end_at" id="" class="form-control flatpickr-end" value="{{ old('end_at', $widget->end_at ?? '') }}">
            </div>
        </div>
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($widget->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($widget) ? 'Update' : 'Create' }} Widget</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

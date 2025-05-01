@php
    $route = 'admin.carousel-slider.';
@endphp

<form action="{{ isset($carousel) ? route( $route . 'update', $carousel->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($carousel))
        @method('PUT')
    @endif


    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($carousel->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($carousel) ? 'Update' : 'Create' }} Carousel Slider</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

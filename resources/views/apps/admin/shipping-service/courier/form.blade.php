@php
    $route = 'admin.shipping-service.courier.';
@endphp

<form action="{{ isset($courier) ? route( $route . 'update', $courier->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($courier))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="shipping_provider" class="form-label">Shipping Provider</label>
        <select name="shipping_provider" id="shipping_provider" class="form-select select2">
            <option value="">Select Shipping Provider</option>
            @forelse($shippingProviders as $o => $shippingProvider)
                <option
                    value="{{ $shippingProvider->id }}"
                    {{ old('shipping_provider', $courier->shipping_provider_id ?? '') == $shippingProvider->id ? 'selected' : '' }}>
                    {{ $shippingProvider->name }}
                </option>
            @empty
            @endforelse
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{!! old('name', $courier->name ?? '') !!}">
    </div>

    <div class="mb-3">
        <label for="service_code" class="form-label">Service Code</label>
        <input type="text" name="service_code" id="service_code" class="form-control" value="{!! old('service_code', $courier->service_code ?? '') !!}">
    </div>

    <div class="mb-3">
        <label for="service_name" class="form-label">Service Name</label>
        <input type="text" name="service_name" id="" class="form-control" value="{!! old('service_name', $courier->service_name ?? '') !!}">
    </div>

    <div class="mb-3">
        <label for="delivery_time" class="form-label">Delivery Time</label>
        <input type="text" name="delivery_time" id="delivery_time" class="form-control" value="{{ old('delivery_time', $courier->delivery_time ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="rate" class="form-label">Rate</label>
        <input type="number" name="rate" id="rate" class="form-control" value="{{ old('rate', $courier->rate ?? '') }}">
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($courier->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($courier) ? 'Update' : 'Create' }} Courier</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

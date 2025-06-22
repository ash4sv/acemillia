@php
    $route = 'admin.shipping-service.shipping-provider.';
@endphp

<form action="{{ isset($shippingProvider) ? route( $route . 'update', $shippingProvider->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($shippingProvider))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $shippingProvider->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="api_key" class="form-label">API Key</label>
        <input type="text" name="api_key" id="api_key" class="form-control" value="{{ old('api_key', $shippingProvider->api_key ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="api_secret" class="form-label">API Secret</label>
        <input type="text" name="api_secret" id="api_secret" class="form-control" value="{{ old('api_secret', $shippingProvider->api_secret ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="demo_url" class="form-label">Demo URL</label>
        <input type="text" name="demo_url" id="live_url" class="form-control" value="{{ old('base_url', $shippingProvider->demo_url ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="live_url" class="form-label">Production URL</label>
        <input type="text" name="live_url" id="live_url" class="form-control" value="{{ old('base_url', $shippingProvider->live_url ?? '') }}">
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($shippingProvider->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($shippingProvider) ? 'Update' : 'Create' }} Shipping Providers</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

@php
    $route = 'admin.menus.';
@endphp

<form id="modal-form" action="{{ isset($menu) ? route( $route . 'update', $menu->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($menu))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control @error('name')is-invalid @enderror" value="{{ old('name', $menu->name ?? '') }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($menu->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($menu) ? 'Update' : 'Create' }} Menu</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

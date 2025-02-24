@php
    $route = 'admin.shop.special-offer.';
@endphp

<form action="{{ isset($specialOffer) ? route( $route . 'update', $specialOffer->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($specialOffer))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="product_id" class="form-label">Select Product</label>
        <select name="product_id" id="product_id" class="form-control select2" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}"
                    {{ (isset($specialOffer) && $specialOffer->product_id == $product->id) ? 'selected' : '' }}>
                    {{ $product->name }} - {{ $product->total_stock }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="discount_type" class="form-label">Discount Type</label>
        <select name="discount_type" id="discount_type" class="form-control select2" required>
            <option value="percentage" {{ (isset($specialOffer) && $specialOffer->discount_type === 'percentage') ? 'selected' : '' }}>Percentage</option>
            <option value="fixed" {{ (isset($specialOffer) && $specialOffer->discount_type === 'fixed') ? 'selected' : '' }}>Fixed Amount</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="discount_amount" class="form-label">Discount Amount</label>
        <input type="number" name="discount_amount" id="discount_amount" class="form-control" value="{{ old('discount_amount', $specialOffer->discount_amount ?? '') }}" required>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control flatpickr-start" value="{{ old('start_date', isset($specialOffer) ? $specialOffer->start_date->format('Y-m-d') : '') }}" required>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control flatpickr-end" value="{{ old('end_date', isset($specialOffer) ? $specialOffer->end_date->format('Y-m-d') : '') }}" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="promotional_text" class="form-label">Promotional Text</label>
        <textarea name="promotional_text" id="promotional_text" class="form-control text-editor">{!! old('promotional_text', $specialOffer->promotional_text ?? '') !!}</textarea>
    </div>

    <div class="mb-3">
        <label for="single_image" class="form-label">Upload Single Image</label>
        <input type="file" name="single_image" id="single_image" class="form-control">
        @if(isset($specialOffer) && $specialOffer->single_image)
            <img src="{{ asset($specialOffer->single_image) }}" alt="Single Image" style="max-width: 150px; margin-top: 10px;">
        @endif
    </div>

    <div class="mb-3">
        <label for="multiple_images" class="form-label">Upload Multiple Images</label>
        <input type="file" name="multiple_images[]" id="multiple_images" class="form-control" multiple>
        @if(isset($specialOffer) && $specialOffer->multiple_images)
            <div class="mt-2">
                @foreach($specialOffer->multiple_images as $image)
                    <img src="{{ asset($image) }}" alt="Multiple Image" style="max-width: 150px; margin-right: 5px;">
                @endforeach
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                {!! \App\Services\Publish::submissionBtn($specialOffer->status_submission ?? 'Pending') !!}
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                {!! \App\Services\Publish::publishBtn($specialOffer->status ?? 'Draft') !!}
            </div>
        </div>
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($specialOffer) ? 'Update' : 'Create' }} Special Offer</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

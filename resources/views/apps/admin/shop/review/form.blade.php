@php
    $route = 'admin.shop.reviews.';
@endphp

<p>Review #{{ $review->id }} for Product: <strong>{{ $review->product->name }}</strong></p>

<div class="mb-3">
    <label>User</label>
    <p class="form-control-plaintext">
        {{ $review->visibility_type->value === 'anonymous' ? 'Anonymous' : ($review->user->name ?? 'Unknown User') }}
    </p>
</div>

<div class="mb-3">
    <label>Rating</label><br>
    @for ($i = 1; $i <= 5; $i++)
        @if ($review->rating >= $i)
            <i class="fa-solid fa-star text-warning"></i>
        @elseif ($review->rating >= $i - 0.5)
            <i class="fa-solid fa-star-half-stroke text-warning"></i>
        @else
            <i class="fa-regular fa-star text-secondary"></i>
        @endif
    @endfor
    <span>({{ number_format($review->rating, 1) }})</span>
</div>

<div class="mb-3">
    <label>Review</label>
    <textarea class="form-control" readonly>{{ $review->review ?? 'No written review.' }}</textarea>
</div>

<form action="{{ isset($review) ? route( $route . 'update', $review->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($review))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="approval_status" class="form-label">Approval Status</label>
        <select class="form-select select2" name="approval_status" id="approval_status" required>
            <option value="">Please Select</option>
            <option value="approved" {{ $review->approval_status->value === 'approved' ? 'selected' : '' }}>Approve</option>
            <option value="rejected" {{ $review->approval_status->value === 'rejected' ? 'selected' : '' }}>Reject</option>
        </select>
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($review) ? 'Update' : 'Create' }} Review</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

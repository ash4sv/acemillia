<div class="card shadow-none border-1 border-solid">
    <x-show-header title="Carousel Slider Details" :editRoute="route('admin.carousel-slider.edit', $carousel->id)" :indexRoute="route('admin.carousel-slider.index')" />
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6 text-center">
                @isset($carousel->image)
                    <img src="{{ asset($carousel->image) }}" alt="Carousel Image" class="img-fluid rounded border" />
                @endisset
            </div>
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($carousel->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $carousel->id }}</dd>
                    @endisset
                    @isset($carousel->url)
                        <dt class="col-sm-4">URL</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                <a href="{{ $carousel->url }}" target="_blank" class="me-2">{{ $carousel->url }}</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary copy-url" data-url="{{ $carousel->url }}" title="Copy URL">
                                    <i class="bx bx-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset
                    @isset($carousel->status)
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($carousel->status) === 'published' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ $carousel->status }}
                            </span>
                        </dd>
                    @endisset
                    @isset($carousel->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $carousel->created_at }}</dd>
                    @endisset
                    @isset($carousel->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $carousel->updated_at }}</dd>
                    @endisset
                </dl>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    document.querySelectorAll('.copy-url').forEach(button => {
        button.addEventListener('click', function () {
            navigator.clipboard.writeText(this.dataset.url);
            this.innerHTML = '<i class="bx bx-check"></i>';
            setTimeout(() => this.innerHTML = '<i class="bx bx-copy"></i>', 2000);
        });
    });
</script>
@endpush

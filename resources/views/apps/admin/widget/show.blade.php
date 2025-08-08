<div class="card shadow-none border-1 border-solid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Widget Details</h5>
        <div class="btn-group">
            <a href="{{ route('admin.widget.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('admin.widget.index') }}" class="btn btn-sm btn-label-secondary">Back</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6 text-center">
                @isset($widget->image)
                    <img src="{{ asset($widget->image) }}" alt="{{ $widget->name }}" class="img-fluid rounded border" />
                @endisset
            </div>
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($widget->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $widget->id }}</dd>
                    @endisset
                    @isset($widget->name)
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $widget->name }}</dd>
                    @endisset
                    @isset($widget->url)
                        <dt class="col-sm-4">URL</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                <a href="{{ $widget->url }}" target="_blank" class="me-2">{{ $widget->url }}</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary copy-url" data-url="{{ $widget->url }}" title="Copy URL">
                                    <i class="bx bx-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset
                    @isset($widget->size)
                        <dt class="col-sm-4">Size</dt>
                        <dd class="col-sm-8">{{ $widget->size }}</dd>
                    @endisset
                    @isset($widget->start_at)
                        <dt class="col-sm-4">Start At</dt>
                        <dd class="col-sm-8">{{ $widget->start_at }}</dd>
                    @endisset
                    @isset($widget->end_at)
                        <dt class="col-sm-4">End At</dt>
                        <dd class="col-sm-8">{{ $widget->end_at }}</dd>
                    @endisset
                    @isset($widget->status)
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($widget->status) === 'active' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ ucfirst($widget->status) }}
                            </span>
                        </dd>
                    @endisset
                    @isset($widget->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $widget->created_at }}</dd>
                    @endisset
                    @isset($widget->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $widget->updated_at }}</dd>
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


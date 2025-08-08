<div class="card shadow-none border-1 border-solid">
    <div class="card-header">
        <h5 class="mb-0">Widget Details</h5>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            @isset($widget->id)
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $widget->id }}</dd>
            @endisset
            @isset($widget->name)
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $widget->name }}</dd>
            @endisset
            @isset($widget->image)
                <dt class="col-sm-3">Image</dt>
                <dd class="col-sm-9">
                    <img src="{{ asset($widget->image) }}" alt="{{ $widget->name }}" class="img-fluid rounded">
                </dd>
            @endisset
            @isset($widget->url)
                <dt class="col-sm-3">URL</dt>
                <dd class="col-sm-9">
                    <a href="{{ $widget->url }}" target="_blank">{{ $widget->url }}</a>
                </dd>
            @endisset
            @isset($widget->size)
                <dt class="col-sm-3">Size</dt>
                <dd class="col-sm-9">{{ $widget->size }}</dd>
            @endisset
            @isset($widget->start_at)
                <dt class="col-sm-3">Start At</dt>
                <dd class="col-sm-9">{{ $widget->start_at }}</dd>
            @endisset
            @isset($widget->end_at)
                <dt class="col-sm-3">End At</dt>
                <dd class="col-sm-9">{{ $widget->end_at }}</dd>
            @endisset
            @isset($widget->status)
                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge {{ $widget->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($widget->status) }}
                    </span>
                </dd>
            @endisset
        </dl>
    </div>
</div>

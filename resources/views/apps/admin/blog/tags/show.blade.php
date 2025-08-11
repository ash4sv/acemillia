<div class="card shadow-none border-1 border-solid">
    <x-show-header title="Tag Details" :editRoute="route('admin.blog.tags.edit', $postTag->id)" :indexRoute="route('admin.blog.tags.index')" />
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6 text-center">
                @isset($postTag->image)
                    <img src="{{ asset($postTag->image) }}" alt="{{ $postTag->name }}" class="img-fluid rounded border" />
                @endisset
            </div>
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($postTag->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $postTag->id }}</dd>
                    @endisset
                    @isset($postTag->name)
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $postTag->name }}</dd>
                    @endisset
                    @isset($postTag->slug)
                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $postTag->slug }}</dd>
                    @endisset
                    @isset($postTag->description)
                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $postTag->description }}</dd>
                    @endisset
                    @isset($postTag->status)
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($postTag->status) === 'active' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ ucfirst($postTag->status) }}
                            </span>
                        </dd>
                    @endisset
                    @isset($postTag->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $postTag->created_at }}</dd>
                    @endisset
                    @isset($postTag->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $postTag->updated_at }}</dd>
                    @endisset
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <h6>Posts</h6>
            @include('apps.admin.partials.relationship-list', [
                'collection' => $postTag->posts,
                'route' => 'admin.blog.posts.show'
            ])
        </div>
    </div>
</div>


<div class="card shadow-none border-1 border-solid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Post Details</h5>
        <div class="btn-group">
            <a href="{{ route('admin.blog.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-sm btn-label-secondary">Back</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6 text-center">
                @isset($post->banner)
                    <img src="{{ asset($post->banner) }}" alt="{{ $post->title }}" class="img-fluid rounded border" />
                @endisset
            </div>
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($post->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $post->id }}</dd>
                    @endisset
                    @isset($post->title)
                        <dt class="col-sm-4">Title</dt>
                        <dd class="col-sm-8">{{ $post->title }}</dd>
                    @endisset
                    @isset($post->slug)
                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $post->slug }}</dd>
                    @endisset
                    @isset($post->body)
                        <dt class="col-sm-4">Body</dt>
                        <dd class="col-sm-8">{!! $post->body !!}</dd>
                    @endisset
                    @isset($post->category)
                        <dt class="col-sm-4">Category</dt>
                        <dd class="col-sm-8">{{ $post->category->name }}</dd>
                    @endisset
                    @isset($post->tags)
                        <dt class="col-sm-4">Tags</dt>
                        <dd class="col-sm-8">
                            @include('apps.admin.partials.relationship-list', [
                                'collection' => $post->tags,
                                'route' => 'admin.blog.tags.show'
                            ])
                        </dd>
                    @endisset
                    @isset($post->author)
                        <dt class="col-sm-4">Author</dt>
                        <dd class="col-sm-8">{{ $post->author->name }}</dd>
                    @endisset
                    @isset($post->status)
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($post->status) === 'published' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </dd>
                    @endisset
                    @isset($post->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $post->created_at }}</dd>
                    @endisset
                    @isset($post->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $post->updated_at }}</dd>
                    @endisset
                </dl>
            </div>
        </div>
    </div>
</div>

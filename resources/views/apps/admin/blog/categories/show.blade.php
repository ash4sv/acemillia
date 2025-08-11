<div class="card shadow-none border-1 border-solid">
    <x-show-header title="Category Details" :editRoute="route('admin.blog.categories.edit', $postCategory->id)" :indexRoute="route('admin.blog.categories.index')" />
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6 text-center">
                @if($postCategory->image)
                    <img src="{{ asset($postCategory->image) }}" alt="{{ $postCategory->name }}" class="img-fluid rounded border" />
                @endif
            </div>
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($postCategory->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $postCategory->id }}</dd>
                    @endisset
                    @isset($postCategory->name)
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $postCategory->name }}</dd>
                    @endisset
                    @isset($postCategory->slug)
                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $postCategory->slug }}</dd>
                    @endisset
                    @isset($postCategory->description)
                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{!! $postCategory->description !!}</dd>
                    @endisset
                    @isset($postCategory->status)
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($postCategory->status) === 'publish' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ ucfirst($postCategory->status) }}
                            </span>
                        </dd>
                    @endisset
                    @isset($postCategory->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $postCategory->created_at }}</dd>
                    @endisset
                    @isset($postCategory->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $postCategory->updated_at }}</dd>
                    @endisset
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <h6>Posts</h6>
            @if($postCategory->posts->count())
                <ul class="list-unstyled mb-0">
                    @foreach($postCategory->posts as $post)
                        <li><a href="{{ route('admin.blog.posts.show', $post->id) }}">{{ $post->title }}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="mb-0">No posts available.</p>
            @endif
        </div>
    </div>
</div>

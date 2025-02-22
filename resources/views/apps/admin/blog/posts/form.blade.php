@php
    $route = 'admin.blog.posts.';
@endphp

<form action="{{ isset($post) ? route( $route . 'update', $post->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($post))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category" class="form-select select2">
            <option value=""></option>
            @foreach($categories as $key => $category)
                <option
                    {{ (isset($post) && $post->post_category_id == $category->id) ? 'selected' : '' }}
                    value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Tag</label>
        <select name="tags" id="tags" class="form-select select2" multiple>
            @php
                $selectedTags = old('categories', $post?->tags?->pluck('id')->toArray() ?? []);
            @endphp
            @foreach($tags as $key => $tag)
                <option
                    {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}
                    value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Name</label>
        <input type="text" name="title" id="" class="form-control @error('title')is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="body" class="form-label">Description</label>
        <textarea name="body" id="" class="form-control text-editor @error('body')is-invalid @enderror">{!! old('body', $post->body ?? '') !!}</textarea>
        @error('description')
        <div class=body>{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="banner" class="form-label">Image Banner</label>
        <input type="file" name="banner" id="" class="form-control @error('banner')is-invalid @enderror" value="{{ old('banner', $post->banner ?? '') }}">
        @if(isset($post) && $post->banner)
            <img src="{{ asset($post->banner) }}" alt="Single Image" style="max-width: 150px; margin-top: 10px;">
        @endif
        @error('banner')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($post->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update' : 'Create' }} Post</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

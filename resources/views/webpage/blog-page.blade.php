@extends('apps.layouts.shop')

@php
    $title = 'Blog';
    $description = '';
    $keywords = '';
    $author = '';
@endphp

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', $title)

@push('style')

@endpush

@push('script')

@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>{!! $title !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! url('/') !!}">{!! __('Home') !!}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('web.blog.index') !!}">{!! __($title) !!}</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- section start -->
    <section class="blog-page section-b-space ratio2_3">
        <div class="container">
            <div class="row g-sm-4 g-3">
                <div class="col-lg-8 col-xxl-9 order-lg-2">
                    <div class="sticky-details">
                        <div class="row g-4">
                            @forelse($posts as $key => $post)
                            @php
                                $postUrl = route('web.blog.post', [$post?->category?->slug, $post?->slug])
                            @endphp
                            <div class="col-sm-6 col-xxl-4">
                                <div class="blog-box sticky-blog-box">
                                    <div class="blog-image">
                                        {{--<div class="blog-featured-tag">
                                            <span>Featured</span>
                                        </div>--}}
                                        {{--<div class="blog-label-tag">
                                            <i class="ri-pushpin-fill"></i>
                                        </div>--}}
                                        <a href="{!! $postUrl !!}">
                                            <img src="{!! asset($post->banner) !!}" alt="{!! __($post->title) !!}">
                                        </a>
                                    </div>
                                    <div class="blog-contain">
                                        <a href="{!! $postUrl !!}"><h3>{!! Str::limit($post->title, 25, '...') !!}</h3></a>
                                        <div class="blog-label">
                                            <span class="time"><i class="ri-time-line"></i><span>{!! $post->created_at->format('d M Y h:i:A') !!}</span></span>
                                            <span class="super"><i class="ri-user-line"></i><span>{!! $post->author?->name !!}</span></span>
                                        </div>
                                        {!! $post->body !!}
                                        <a class="blog-button" href="{!! $postUrl !!}">Read More <i class="ri-arrow-right-line"></i></a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-sm-12 col-xxl-12">
                                <div class="blog-box sticky-blog-box">
                                    <div class="blog-contain">
                                        <a href="">
                                            <h3>No posting</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        {{ $posts->links('apps.layouts.pagination-custom') }}
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="blog-sidebar">
                        @if(isset($recentPosts) && $recentPosts->count() > 0)
                        <div class="theme-card">
                            <h4>Recent Blog</h4>
                            <ul class="recent-blog">
                                @forelse($recentPosts as $key => $post)
                                <li>
                                    <div class="media blog-box">
                                        <div class="blog-image">
                                            <img class="img-fluid lazyload" src="{!! asset($post->banner) !!}" alt="{!! $post->title !!}">
                                        </div>
                                        <div class="media-body blog-content">
                                            <h6>{!! $post->created_at->format('d M Y h:i:A') !!}</h6>
                                            <a href="{!! route('web.blog.post', [$post?->category?->slug, $post?->slug]) !!}"><h5 class="recent-name">{!! Str::limit($post->title, 20, '...') !!}</h5></a>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li>
                                    No recent blog posting
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        @endif

                        @if(isset($categoriesSidebar) && $categoriesSidebar->count() > 0)
                        <div class="theme-card">
                            <h4>Categories</h4>
                            <ul class="categories">
                                @forelse($categoriesSidebar as $key => $category)
                                <li>
                                    <a class="category-name" href="{!! route('web.blog.category', $category->slug) !!}">
                                        <h5>{!! __($category->name) !!}</h5><span>{!! '(' . $category?->posts->count() . ')' !!}</span>
                                    </a>
                                </li>
                                @empty
                                <li>
                                    <a class="category-name" href="">
                                        <h5>{!! __('No registered category') !!}</h5>
                                    </a>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        @endif

                        @if(isset($tagsSidebar) && $tagsSidebar->count() > 0)
                        <div class="theme-card">
                            <h4>Tags</h4>
                            <ul class="tags">
                                @forelse($tagsSidebar as $key => $tag)
                                <li><a href="#!">{!! __($tag->name) !!}</a></li>
                                @empty
                                <li><a href="#!">{!! __('No registered tag') !!}</a></li>
                                @endforelse
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

@endsection

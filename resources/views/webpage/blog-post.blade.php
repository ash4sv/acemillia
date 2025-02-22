@extends('apps.layouts.shop')

@php
    $title = $post->title;
    $description = '';
    $keywords = '';
    $author = $post?->author?->name;
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
                    <li class="breadcrumb-item"><a href="{!! route('web.blog.index') !!}">{!! __('Blog') !!}</a></li>
                    @if(isset($post->category) && $post->category->count() > 0)
                    <li class="breadcrumb-item"><a href="{!! route('web.blog.category', $post?->category?->slug) !!}">{!! __($post?->category?->name) !!}</a></li>
                    @endif
                    @if(isset($post))
                    <li class="breadcrumb-item"><a href="">{!! __($title) !!}</a></li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="blog-detail-page section-b-space ratio2_3">
        <div class="container">
            <div class="blog-detail">
                <img class="img-fluid" src="{!! asset($post?->banner) !!}" alt="{!! $title !!}">
                <h3>{!! $title !!}</h3>
                <ul class="post-social">
                    <li>{!! $post->created_at->format('d M Y h:i:A') !!}</li>
                    @if($post?->author)
                    <li>Posted By : {!! $post?->author?->name !!}</li>
                    @endif
                </ul>
            </div>
            <div class="blog-detail-contain">
                {!! $post?->body !!}
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection

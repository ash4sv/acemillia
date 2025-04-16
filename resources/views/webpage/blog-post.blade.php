@extends('apps.layouts.shop')

@php
    $title = $post->title;
    $description = $post->body;
    $keywords = $post->tags->pluck('name')->implode(', ');
    $author = $post?->author?->name;
@endphp

@section('description', $description)
@section('keywords', $keywords)
@section('author', $author)
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
                    @foreach ($breadcrumbs ?? [] as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if (!empty($breadcrumb['url']))
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
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

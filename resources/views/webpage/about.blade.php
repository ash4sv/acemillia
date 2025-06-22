@extends('apps.layouts.shop')

@php
    $title = '';
    $description = '';
    $keywords = '';
    $author = '';
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
    <section class="blog-detail-page all-new-writeup section-b-space ratio2_3">
        <div class="container">
            <h1>About Us</h1>

            <h3>ACEMILLIA PHARMACEUTICALS (M) SDN. BHD.</h3>
            <p>Founded in 2018, ACEMILLIA Pharmaceuticals is dedicated to addressing unmet medical needs and pushing the boundaries of science. Our mission—“We strive to make a meaningful difference in the lives of people around the world by addressing unmet medical needs and advancing the boundaries of science.”—drives every innovation and partnership.</p>

            <h2>What We Do</h2>
            <ul class="list-bullet">
                <li><strong>Pharmaceuticals Marketing:</strong> Leveraging deep industry relationships and strategic insights, we connect leading-edge therapies with healthcare providers, corporate procurement teams, SMEs, and end consumers.</li>
                <li><strong>Strategic Partnerships:</strong> We collaborate with global R&D partners to co-develop and co-promote products that enhance patient outcomes.</li>
            </ul>

            <h2>Our Vision</h2>
            <p>“To be a global leader in pharmaceutical innovation, delivering breakthrough therapies that enhance the quality of life and empower healthier futures.”</p>

            <h2>Why Choose Us</h2>
            <ul class="list-bullet">
                <li><strong>Innovative:</strong> We constantly seek novel approaches to complex medical challenges.</li>
                <li><strong>Authoritative:</strong> Our team’s expertise ensures compliance, quality, and reliability at every step.</li>
                <li><strong>Approachable:</strong> We build lasting relationships through transparent communication and customer-centric service.</li>
            </ul>
        </div>
    </section>
    <!--Section ends-->

@endsection

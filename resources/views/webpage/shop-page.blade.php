@extends('apps.layouts.shop')

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', $menuSlug->name)

@push('style')
    <style>
        .basic-product .img-wrapper {
            /*min-height:351px;*/
        }
    </style>
@endpush

@push('script')
    <script src="{!! asset('assets/js/compare-class.js') !!}"></script>
    <script>
        $(document).ready(function() {
            console.log({!! $products->count() !!});
            var menuSlug = "{{ $menuSlug->slug }}";
            var categorySlug = "{{ isset($category) ? $category->slug : '' }}";

            // -------------------------
            // Load More and Quantity Logic
            // -------------------------
            function getInitialCount() {
                var quantityOptionText = $('.product-filter-content select.form-select.quantity option:selected').text();
                var count = parseInt(quantityOptionText, 10);
                return count ? count : 10;
            }

            function bindLoadMore() {
                $(".loadMore").off('click').on('click', function(e) {
                    e.preventDefault();
                    $(".product-load-more .col-grid-box:hidden").slice(0, 4).slideDown();
                    if ($(".product-load-more .col-grid-box:hidden").length === 0) {
                        $(this).text('no more products');
                    }
                });
            }

            function initLoadMore() {
                var initialCount = getInitialCount();
                $(".product-load-more .col-grid-box").hide();
                $(".product-load-more .col-grid-box").slice(0, initialCount).show();
                $(".loadMore").text('loadmore');
                bindLoadMore();
            }

            function updateVisibleCount(newCount) {
                var visibleCount = $(".product-load-more .col-grid-box:visible").length;
                if (newCount > visibleCount) {
                    $(".product-load-more .col-grid-box").slice(visibleCount, newCount).slideDown();
                } else if (newCount < visibleCount) {
                    $(".product-load-more .col-grid-box").slice(newCount).slideUp();
                }
                bindLoadMore();
            }

            initLoadMore();

            $('.product-filter-content select.form-select.quantity').on('change', function() {
                var newCount = getInitialCount();
                updateVisibleCount(newCount);
            });

            // -------------------------
            // Sorting AJAX Logic
            // -------------------------
            $('.product-filter-content select.form-select').eq(0).on('change', function() {
                var selectedValue = $(this).val();
                var sortParam = '';
                if (selectedValue === "" || selectedValue === null) {
                    sortParam = "asc";
                } else if (selectedValue == "1") {
                    sortParam = "desc";
                } else if (selectedValue == "2") {
                    sortParam = "low-high";
                } else if (selectedValue == "3") {
                    sortParam = "high-low";
                }

                var url = '';
                if (categorySlug !== "") {
                    url = "{{ route('web.shop.category.sort', ['menu' => 'MENU_PLACEHOLDER', 'category' => 'CATEGORY_PLACEHOLDER']) }}";
                    url = url.replace('MENU_PLACEHOLDER', menuSlug).replace('CATEGORY_PLACEHOLDER', categorySlug);
                } else {
                    url = "{{ route('web.shop.menu.sort', ['menu' => 'MENU_PLACEHOLDER']) }}";
                    url = url.replace('MENU_PLACEHOLDER', menuSlug);
                }
                url += '?sort=' + sortParam;

                if ($('#loadingOverlay').length === 0) {
                    $('body').append(
                        '<div id="loadingOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0 ,0 ,0 ,0.7); display: flex; align-items: center; justify-content: center; z-index: 9999;">' +
                        '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>' +
                        '</div>'
                    );
                } else {
                    $('#loadingOverlay').show();
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('.product-wrapper-grid .acemillia-shop-product').html(response);
                        $('#loadingOverlay').fadeOut();
                        initLoadMore();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sorted products:', error);
                        $('#loadingOverlay').fadeOut();
                    }
                });
            });
            // -------------------------
            // Grid Layout Toggle Code
            // -------------------------
            // Remove grid classes but preserve "col-grid-box"
            function removeColClasses($elem) {
                $elem.removeClass(function(index, className) {
                    // This regex matches classes starting with "col-" except "col-grid-box"
                    return (className.match(/\bcol-(?!grid-box)\S+/g) || []).join(' ');
                });
            }

            // List layout view toggle
            $('.list-layout-view').on('click', function(e) {
                e.preventDefault();
                $(".product-wrapper-grid").css("opacity", "0.2");
                $('.shop-cart-ajax-loader').css("display", "block");
                $('.product-wrapper-grid').addClass("list-view");
                // Only remove grid system classes, preserving "col-grid-box"
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-sm-12 col-6");
                $(".grid-icon").removeClass('active');
                $(this).addClass('active');
                setTimeout(function() {
                    $(".product-wrapper-grid").css("opacity", "1");
                    $('.shop-cart-ajax-loader').css("display", "none");
                }, 500);
            });

            // Grid layout view toggles
            $('.product-2-layout-view, .product-3-layout-view, .product-4-layout-view, .product-6-layout-view').on('click', function(e) {
                e.preventDefault();
                $('.product-wrapper-grid').removeClass("list-view");
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-lg-3");
            });

            $('.product-2-layout-view').on('click', function(e) {
                e.preventDefault();
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-6");
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.product-3-layout-view').on('click', function(e) {
                e.preventDefault();
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-xl-4 col-6");
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.product-4-layout-view').on('click', function(e) {
                e.preventDefault();
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-xl-3 col-6");
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.product-6-layout-view').on('click', function(e) {
                e.preventDefault();
                removeColClasses($(".product-wrapper-grid .col-grid-box"));
                $(".product-wrapper-grid .col-grid-box").addClass("col-lg-2");
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.shortcut-add-to-cart').each(function(){
                var $form = $(this);
                var basePrice = parseFloat($form.find('input[name="base-price"]').val());
                var additionalTotal = 0;

                $form.find('input[type="radio"]:checked').each(function(){
                    var addPrice = parseFloat($(this).data('additional-price')) || 0;
                    additionalTotal += addPrice;
                });

                var finalPrice = basePrice + additionalTotal;

                $form.find('input[name="price"]').val(finalPrice.toFixed(2));
            });
        });
    </script>
@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>{!! $menuSlug->name !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                    @if(isset($menuSlug))
                    <li class="breadcrumb-item"><a href="{!! route('web.shop.index', $menuSlug->slug) !!}">{!! $menuSlug->name !!}</a></li>
                    @endif
                    @if(isset($category))
                    <li class="breadcrumb-item"><a href="{!! route('web.shop.category', [$menuSlug->slug, $category->slug]) !!}">{!! $category->name !!}</a></li>
                    @endif
                    @if(isset($product->sub_categories) && $product->sub_categories->isNotEmpty())
                    <li class="breadcrumb-item"><a href="">{!! $product->sub_categories->pluck('name')->implode('/') !!}</a></li>
                    @endif
                    @if(isset($product))
                    <li class="breadcrumb-item active">{!! strtoupper($product->name) !!}</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 collection-filter">
                        <!-- side-bar collapse block stat -->
                        <div class="collection-filter-block">
                            <!-- brand filter start -->
                            <div class="collection-mobile-back">
                                <span class="filter-back"><i class="ri-arrow-left-s-line"></i> {!! __('back') !!}</span>
                            </div>
                            <div class="collection-collapse-block open">
                                <div class="accordion collection-accordion" id="accordionPanelsStayOpenExample">
                                    @if(isset($categories) && $categories->isNotEmpty())
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">Categories</button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="collection-listing">
                                                    @forelse($categories as $key => $category)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="{{ $key . '-' . $category->id }}">
                                                            <label class="form-check-label" for="{{ $key . '-' . $category->id }}">{{ Str::limit($category->name, 24, '...') }}</label>
                                                        </div>
                                                    </li>
                                                    @empty
                                                    <li>

                                                    </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(isset($subCategories) && $subCategories->isNotEmpty())
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">Sub Categories</button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="collection-listing">
                                                    @forelse($subCategories as $key => $category)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="{{ $key . '-' . $category->id }}">
                                                            <label class="form-check-label" for="{{ $key . '-' . $category->id }}">{{ Str::limit($category->name, 20, '...') }}</label>
                                                        </div>
                                                    </li>
                                                    @empty
                                                    <li>

                                                    </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    {{--<div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">Brand </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="collection-listing">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox11">
                                                            <label class="form-check-label" for="checkbox11">Couture Edge</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox12">
                                                            <label class="form-check-label" for="checkbox12">Glamour Gaze</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox13">
                                                            <label class="form-check-label" for="checkbox13">Urban Chic</label>
                                                        </div>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox14">
                                                            <label class="form-check-label" for="checkbox14">VogueVista</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox15">
                                                            <label class="form-check-label" for="checkbox15">Velocity Vibe</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox16">
                                                            <label class="form-check-label" for="checkbox16">Nourish Naturally</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>--}}
                                    {{--<div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">Colours </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="collection-listing">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox31">
                                                            <label class="form-check-label" for="checkbox31">Blue</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox32">
                                                            <label class="form-check-label" for="checkbox32">Green</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox33">
                                                            <label class="form-check-label" for="checkbox33">Red</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox34">
                                                            <label class="form-check-label" for="checkbox34">Beige</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox35">
                                                            <label class="form-check-label" for="checkbox35">Black</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox36">
                                                            <label class="form-check-label" for="checkbox36">Brown</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>--}}

                                    {{--<div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">Rating</button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="collection-listing">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox51">
                                                            <label class="form-check-label" for="checkbox51">
                                                                <span>
                                                                    <span class="star-rating">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                    </span>
                                                                    <span>(5 Star)</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox52">
                                                            <label class="form-check-label" for="checkbox52">
                                                                <span>
                                                                    <span class="star-rating">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <span>(4 Star)</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox53">
                                                            <label class="form-check-label" for="checkbox53">
                                                                <span>
                                                                    <span class="star-rating">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <span>(3 Star)</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox54">
                                                            <label class="form-check-label" for="checkbox54">
                                                                <span>
                                                                    <span class="star-rating">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <span>(2 Star)</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox55">
                                                            <label class="form-check-label" for="checkbox55">
                                                                <span>
                                                                    <span class="star-rating">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <span>(1 Star)</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>--}}
                                    {{--<div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">Price</button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse show">
                                            <div class="accordion-body price-body">
                                                <div class="wrapper">
                                                    <div class="range-slider">
                                                        <input type="text" class="js-range-slider" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <!-- side-bar collapse block end here -->
                    </div>
                    <div class="collection-content col-xl-9 col-lg-8">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    @isset($category->image)
                                    <div class="top-banner-wrapper">
                                        <a href="{{--{{ route('web.shop.index', $category->slug) }}--}}">
                                            <img src="{{ asset($category->image) }}" class="img-fluid blur-up lazyload" alt="">
                                        </a>
                                    </div>
                                    @endisset
                                    <button class="filter-btn btn">
                                        <i class="ri-arrow-left-s-line"></i> Filter
                                    </button>
                                    <div class="collection-product-wrapper acemillia-shop">
                                        <div class="product-top-filter">
                                            <div class="product-filter-content w-100">
                                                <div class="d-flex align-items-center gap-sm-3 gap-2">
                                                    <select class="form-select sort">
                                                        <option selected>Ascending Order</option>
                                                        <option value="1">Descending Order</option>
                                                        <option value="2">Low - High Price</option>
                                                        <option value="3">High - Low Price</option>
                                                    </select>
                                                    <select class="form-select quantity">
                                                        <option selected>10 Products</option>
                                                        <option value="1">25 Products</option>
                                                        <option value="2">50 Products</option>
                                                        <option value="3">100 Products</option>
                                                    </select>
                                                </div>
                                                <div class="collection-grid-view">
                                                    <ul>
                                                        <li class="product-2-layout-view grid-icon">
                                                            <img src="{{ asset('assets/images/inner-page/icon/2.png') }}" alt="sort" class=" ">
                                                        </li>
                                                        <li class="product-3-layout-view grid-icon active">
                                                            <img src="{{ asset('assets/images/inner-page/icon/3.png') }}" alt="sort" class=" ">
                                                        </li>
                                                        <li class="product-4-layout-view grid-icon">
                                                            <img src="{{ asset('assets/images/inner-page/icon/4.png') }}" alt="sort" class=" ">
                                                        </li>
                                                        <li class="list-layout-view list-icon">
                                                            <img src="{{ asset('assets/images/inner-page/icon/list.png') }}" alt="sort" class=" ">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid product-load-more">
                                            <div class="acemillia-shop-product">
                                                <div class="row g-3 g-sm-4">
                                                    @forelse($products as $key => $product)
                                                        @php
                                                            $url = route('web.shop.product', [$menuSlug->slug, $product->categories->pluck('slug')->first(), $product->slug]);
                                                            [$minPrice, $maxPrice] = $product->min_max_price;
                                                        @endphp
                                                        <div class="col-xl-4 col-6 col-grid-box">
                                                            <div class="basic-product theme-product-1">
                                                                <div class="overflow-hidden">
                                                                    <div class="img-wrapper">
                                                                        <a href="{!! $url !!}">
                                                                            <img src="{{ asset($product->merged_images->first()) }}" class="w-100 img-fluid blur-up lazyload" alt="">
                                                                        </a>
                                                                        {{--<div class="rating-label">
                                                                            <i class="ri-star-fill"></i>
                                                                            <span>4.5</span>
                                                                        </div>--}}
                                                                        <div class="cart-info">
                                                                            <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                                                                <i class="ri-heart-line"></i>
                                                                            </a>
                                                                            <a href="javascript:void(0);" onclick="event.preventDefault(); $('#add-to-cart-{{ __($product->slug . '-' . $product->id) }}').trigger('submit');">
                                                                                <i class="ri-shopping-cart-line"></i>
                                                                            </a>
                                                                            <form class="shortcut-add-to-cart d-none" id="add-to-cart-{{ __($product->slug . '-' . $product->id) }}" action="{{ route('purchase.add-to-cart') }}" method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="product" readonly value="{{ $product->id }}">
                                                                                <input type="hidden" name="price" readonly value="{{ $product->price }}">
                                                                                <input type="hidden" name="base-price" class="base-price" value="{{ (float) $product->getRawOriginal('price') }}">
                                                                                <input type="hidden" name="quantity" value="1" />
                                                                                @php
                                                                                    $sortedOptions = $product->options->sortBy('name');
                                                                                @endphp
                                                                                @foreach($sortedOptions as $p => $option)
                                                                                    <input type="hidden" name="options[{{ $p }}][option]" value="{{ $option->id }}">
                                                                                    @forelse($option->values as $i => $value)
                                                                                        <input type="radio"
                                                                                               id="option{{ $p }}-{{ $i }}"
                                                                                               name="options[{{ $p }}][value]"
                                                                                               value="{{ $value->id }}"
                                                                                               data-additional-price="{{ $value->additional_price }}"
                                                                                            {{ $loop->first ? 'checked' : '' }} hidden>
                                                                                    @empty
                                                                                        {{-- No values for this option --}}
                                                                                    @endforelse
                                                                                @endforeach
                                                                            </form>
                                                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{!! route('web.shop.quickview', $product->slug) !!}" data-create-title="Quick View">
                                                                                <i class="ri-eye-line"></i>
                                                                            </a>
                                                                            <a href="javascript:void(0);"
                                                                               title="Compare"
                                                                               class="ajax-compare"
                                                                               data-compare-product-id="{{ $product->id }}"
                                                                               data-compare-action="{{ route('compare.store') }}"
                                                                               data-compare-method="POST">
                                                                                <i class="ri-loop-left-line"></i>
                                                                            </a>

                                                                        </div>
                                                                    </div>
                                                                    <div class="product-detail">
                                                                        <div>
                                                                            <div class="brand-w-color">
                                                                                <a class="product-title" href="{!! $url !!}">{!! $product->name !!}</a>
                                                                            </div>

                                                                            {{--<h6>Purple Mini Dress</h6>--}}
                                                                            <p>{!! Str::limit($product->product_description, 225, '...') !!}</p>

                                                                            <h4 class="price">
                                                                                @if(abs($minPrice - $maxPrice) < 0.0001)
                                                                                    {{ 'RM' . number_format($minPrice, 2) }}
                                                                                @else
                                                                                    {{ 'RM' . number_format($minPrice, 2) }}
                                                                                    -
                                                                                    {{ 'RM' . number_format($maxPrice, 2) }}
                                                                                @endif
                                                                                {{--<del> $5.00 </del>--}}
                                                                                {{--<span class="discounted-price"> 5% Off</span>--}}
                                                                            </h4>
                                                                        </div>
                                                                        <ul class="offer-panel">
                                                                            <li>
                                                                        <span class="offer-icon">
                                                                            <i class="ri-discount-percent-fill"></i>
                                                                        </span>
                                                                                Limited Time Offer: 5% off
                                                                            </li>
                                                                            <li>
                                                                        <span class="offer-icon">
                                                                            <i class="ri-discount-percent-fill"></i>
                                                                        </span>
                                                                                Limited Time Offer: 5% off
                                                                            </li>
                                                                            <li>
                                                                        <span class="offer-icon">
                                                                            <i class="ri-discount-percent-fill"></i>
                                                                        </span>
                                                                                Limited Time Offer: 5% off
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty

                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        <div class="load-more-sec">
                                            <a href="javascript:void(0)" class="loadMore">loadmore</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section End -->

@endsection

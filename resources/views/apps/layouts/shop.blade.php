<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/furniture-3/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/furniture-3/favicon.png') }}" type="image/x-icon">

    <title>@yield('title') :: One Stop Centre for Your Needs</title>

    <!--Google font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Yellowtail&amp;display=swap">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Recursive:wght@400;500;600;700;800;900&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&amp;family=Montserrat:ital,wght@0,100..900;1,100..900&amp;display=swap">

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/remixicon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/price-range.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('apps/vendor/libs/fancyapps/fancybox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('apps/vendor/libs/selectize/css/selectize.default.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('apps/vendor/libs/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('apps/vendor/libs/summernote/dist/summernote-lite.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('apps/vendor/libs/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/overwrite-style.css') }}">

    @stack('style')

</head>

<body class="theme-color-22">

    @include('apps.layouts.shop-header')

    @yield('webpage')

    @include('apps.layouts.shop-footer')


    {{-- <!-- offer section start -->
    <div class="sale-box" data-bs-toggle="modal" data-bs-target="#blackfriday">
        <div class="heading-right">
            <h3>Black Friday</h3>
        </div>
    </div>
    <!-- offer section end -->

    <!--modal popup start-->
    <div class="modal fade bd-example-modal-lg blackfriday-modal" id="blackfriday" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg">
                                    <div class="side-lines"><span></span></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                    </button>
                                    <div class="confetti">
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                        <div class="confetti-piece"></div>
                                    </div>
                                    <div class="content">
                                        <h1>Black</h1>
                                        <h1>Friday</h1>
                                        <h2>sale</h2>
                                        <div class="discount">get
                                            <span>30%</span>
                                            off
                                            <span class="plus">+</span>
                                            <span>FREE SHIPPING</span>
                                        </div>
                                        <div class="btn btn-solid">USE CODE: <span>BLACK</span></div>
                                        <p>*check shipping conditions in our website</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--modal popup end-->--}}

    <!-- Quick View modal popup start-->
    <div class="modal fade theme-modal-2 quick-view-modal" id="quickView">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ri-close-line"></i>
                </button>
                <div class="modal-body">
                    <div class="wrap-modal-slider">
                        <div class="row g-sm-4 g-3">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="view-main-slider">
                                            <div>
                                                <img src="{{ asset('assets/images/fashion-1/product/1.jpg') }}" class="img-fluid"
                                                    alt="">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/images/fashion-1/product/1-1.jpg') }}" class="img-fluid"
                                                    alt="">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/images/fashion-1/product/1-2.jpg') }}" class="img-fluid"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="view-thumbnail-slider no-arrow">
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{ asset('assets/images/fashion-1/product/1.jpg') }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{ asset('assets/images/fashion-1/product/1-1.jpg') }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{ asset('assets/images/fashion-1/product/1-2.jpg') }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="right-sidebar-modal">
                                    <a class="name" href="product-page(accordian).html">Boyfriend Shirts</a>
                                    <div class="product-rating">
                                        <ul class="rating-list">
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                        </ul>
                                        <div class="divider">|</div>
                                        <a href="#!">0 Review</a>
                                    </div>
                                    <div class="price-text">
                                        <h3>
                                            <span class="fw-normal">MRP:</span>
                                            $10.56
                                            <del>$12.00</del>
                                            <span class="discounted-price">12% off</span>
                                        </h3>
                                        <span class="text">Inclusive all the text</span>
                                    </div>
                                    <p class="description-text">Boyfriend shirts are oversized, relaxed-fit shirts
                                        originally inspired by men's fashion. They offer a comfortable and effortlessly
                                        chic look, often characterized by a loose silhouette and rolled-up sleeves.
                                        Perfect for a casual yet stylish vibe</p>
                                    <div class="variation-box size-box my-3">
                                        <h4 class="sub-title">Size :</h4>
                                        <ul class="quantity-variant custom-variations circle d-inline-flex">
                                            <li class="active">
                                                <button type="button" class=""> S </button>
                                            </li>

                                            <li>
                                                <button type="button"> M </button>
                                            </li>

                                            <li>
                                                <button type="button"> L </button>
                                            </li>

                                            <li>
                                                <button type="button"> XL </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="qty-box">
                                        <div class="input-group qty-container">
                                            <button class="btn qty-btn-minus">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </button>
                                            <input type="number" readonly="" name="qty" class="form-control input-qty"
                                                value="1">
                                            <button class="btn qty-btn-plus">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-buy-btn-group">
                                        <button class="btn btn-animation btn-solid buy-button hover-solid scroll-button">
                                            <i class="ri-shopping-cart-line me-1"></i>
                                            Add To Cart
                                        </button>
                                        <button class="btn btn-solid buy-button">Buy Now</button>
                                    </div>

                                    <div class="buy-box compare-box">
                                        <a href="#!">
                                            <i class="ri-heart-line"></i>
                                            <span>Add To Wishlist</span>
                                        </a>
                                        <a href="#!">
                                            <i class="ri-refresh-line"></i>
                                            <span>Add To Compare</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View modal popup end-->


    <!-- Add to cart modal popup start-->
    <div class="modal fade bd-example-modal-lg theme-modal cart-modal" id="addtocart" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg addtocart">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                    </button>
                                    <div class="media">
                                        <a href="#!">
                                            <img class="img-fluid blur-up lazyload pro-img" src="{{ asset('assets/images/fashion/product/55.jpg') }}" alt="">
                                        </a>
                                        <div class="media-body align-self-center text-center">
                                            <a href="#!">
                                                <h6>
                                                    <i class="fa fa-check"></i>Item
                                                    <span>men full sleeves</span>
                                                    <span> successfully added to your Cart</span>
                                                </h6>
                                            </a>
                                            <div class="buttons">
                                                <a href="#!" class="view-cart btn btn-solid">Your cart</a>
                                                <a href="#!" class="checkout btn btn-solid">Check out</a>
                                                <a href="#!" class="continue btn btn-solid">Continue shopping</a>
                                            </div>
                                            <div class="upsell_payment">
                                                <img src="{{ asset('assets/images/payment_cart.png') }}" class="img-fluid blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-section">
                                        <div class="col-12 product-upsell text-center">
                                            <h4>Customers who bought this item also.</h4>
                                        </div>
                                        <div class="row" id="upsell_product">
                                            <div class="product-box col-sm-3 col-6">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="#!">
                                                            <img src="{{ asset('assets/images/fashion/product/1.jpg') }}" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                        </a>
                                                    </div>
                                                    <div class="product-detail">
                                                        <h6><a href="#!"><span>cotton top</span></a></h6>
                                                        <h4><span>$25</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-box col-sm-3 col-6">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="#!">
                                                            <img src="{{ asset('assets/images/fashion/product/34.jpg') }}" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                        </a>
                                                    </div>
                                                    <div class="product-detail">
                                                        <h6><a href="#!"><span>cotton top</span></a></h6>
                                                        <h4><span>$25</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-box col-sm-3 col-6">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="#!">
                                                            <img src="{{ asset('assets/images/fashion/product/13.jpg') }}" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                        </a>
                                                    </div>
                                                    <div class="product-detail">
                                                        <h6><a href="#!"><span>cotton top</span></a></h6>
                                                        <h4><span>$25</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-box col-sm-3 col-6">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="#!">
                                                            <img src="{{ asset('assets/images/fashion/product/19.jpg') }}" class="img-fluid blur-up lazyload mb-1" alt="cotton top">
                                                        </a>
                                                    </div>
                                                    <div class="product-detail">
                                                        <h6><a href="#!"><span>cotton top</span></a></h6>
                                                        <h4><span>$25</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add to cart modal popup end-->


    <!-- Search Modal Start -->
    <div class="modal fade search-modal theme-modal-2" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Search in store</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="search-input-box">
                        <input type="text" class="form-control" placeholder="Search with brands and categories...">
                        <i class="ri-search-2-line"></i>
                    </div>

                    <ul class="search-category">
                        <li class="category-title">Top search:</li>
                        <li>
                            <a href="category-page.html">Baby Essentials</a>
                        </li>
                        <li>
                            <a href="category-page.html">Bag Emporium</a>
                        </li>
                        <li>
                            <a href="category-page.html">Bags</a>
                        </li>
                        <li>
                            <a href="category-page.html">Books</a>
                        </li>
                    </ul>

                    <div class="search-product-box mt-sm-4 mt-3">
                        <h3 class="search-title">Most Searched</h3>

                        <div class="row row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3">
                            <div class="col">
                                <div class="basic-product theme-product-1">
                                    <div class="overflow-hidden">
                                        <div class="img-wrapper">
                                            <div class="ribbon"><span>Exclusive</span></div>
                                            <a href="product-page(image-swatch).html">
                                                <img src="{{ asset('assets/images/fashion-1/product/1.jpg') }}" class="img-fluid blur-up lazyloaded" alt="">
                                            </a>
                                            <div class="rating-label"><i class="ri-star-fill"></i><span>2.5</span>
                                            </div>
                                            <div class="cart-info">
                                                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                                <button data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas"
                                                    title="Add to cart">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </button>
                                                <a href="#quickView" data-bs-toggle="modal" title="Quick View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-loop-left-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <div>
                                                <div class="brand-w-color">
                                                    <a class="product-title" href="product-page(accordian).html">
                                                        Glamour Gaze
                                                    </a>
                                                    <div class="color-panel">
                                                        <ul>
                                                            <li style="background-color: papayawhip;"></li>
                                                            <li style="background-color: burlywood;"></li>
                                                            <li style="background-color: gainsboro;"></li>
                                                        </ul>
                                                        <span>+2</span>
                                                    </div>
                                                </div>
                                                <h6>Boyfriend Shirts</h6>
                                                <h4 class="price">$ 2.79<del> $3.00 </del>
                                                    <span class="discounted-price">
                                                        7% Off
                                                    </span>
                                                </h4>
                                            </div>
                                            <ul class="offer-panel">
                                                <li>
                                                    <span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 4% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 4% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 4% off
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="basic-product theme-product-1">
                                    <div class="overflow-hidden">
                                        <div class="img-wrapper">
                                            <a href="product-page(accordian).html"><img src="{{ asset('assets/images/fashion-1/product/11.jpg') }}" class="img-fluid blur-up lazyloaded" alt=""></a>
                                            <div class="rating-label"><i class="fa fa-star"></i>
                                                <span>6.5</span>
                                            </div>
                                            <div class="cart-info">
                                                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                                <button data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas"
                                                    title="Add to cart">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </button>
                                                <a href="#quickView" data-bs-toggle="modal" title="Quick View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-loop-left-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <div>
                                                <div class="brand-w-color">
                                                    <a class="product-title" href="product-page(accordian).html">
                                                        VogueVista
                                                    </a>
                                                </div>
                                                <h6>Chic Crop Top</h6>
                                                <h4 class="price">$ 5.60<del> $6.80 </del>
                                                    <span class="discounted-price"> 5% Off </span>
                                                </h4>
                                            </div>
                                            <ul class="offer-panel">
                                                <li>
                                                    <span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 25% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 25% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 25% off
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="basic-product theme-product-1">
                                    <div class="overflow-hidden">
                                        <div class="img-wrapper">
                                            <a href="product-page(accordian).html">
                                                <img src="{{ asset('assets/images/fashion-1/product/15.jpg') }}" class="img-fluid blur-up lazyloaded" alt="">
                                            </a>
                                            <div class="rating-label"><i class="fa fa-star"></i>
                                                <span>3.7</span>
                                            </div>
                                            <div class="cart-info">
                                                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                                <button data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas"
                                                    title="Add to cart">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </button>
                                                <a href="#quickView" data-bs-toggle="modal" title="Quick View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-loop-left-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <div>
                                                <div class="brand-w-color">
                                                    <a class="product-title" href="product-page(accordian).html">
                                                        Urban Chic
                                                    </a>
                                                </div>
                                                <h6>Classic Jacket</h6>
                                                <h4 class="price">$ 3.80 </h4>
                                            </div>
                                            <ul class="offer-panel">
                                                <li><span class="offer-icon"><i
                                                            class="ri-discount-percent-fill"></i></span>
                                                    Limited Time Offer: 10% off</li>
                                                <li><span class="offer-icon"><i
                                                            class="ri-discount-percent-fill"></i></span>
                                                    Limited Time Offer: 10% off</li>
                                                <li><span class="offer-icon"><i
                                                            class="ri-discount-percent-fill"></i></span>
                                                    Limited Time Offer: 10% off</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="basic-product theme-product-1">
                                    <div class="overflow-hidden">
                                        <div class="img-wrapper">
                                            <a href="product-page(image-swatch).html">
                                                <img src="{{ asset('assets/images/fashion-1/product/16.jpg') }}" class="img-fluid blur-up lazyloaded" alt="">
                                            </a>
                                            <div class="rating-label"><i class="fa fa-star"></i>
                                                <span>8.7</span>
                                            </div>
                                            <div class="cart-info">
                                                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                                    <i class="ri-heart-line"></i>
                                                </a>
                                                <button data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" title="Add to cart">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </button>
                                                <a href="#quickView" data-bs-toggle="modal" title="Quick View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="compare.html" title="Compare">
                                                    <i class="ri-loop-left-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <div>
                                                <div class="brand-w-color">
                                                    <a class="product-title" href="product-page(accordian).html">
                                                        Couture Edge
                                                    </a>
                                                </div>
                                                <h6>Versatile Shacket</h6>
                                                <h4 class="price"> $3.00
                                                </h4>
                                            </div>
                                            <ul class="offer-panel">
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 12% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 12% off
                                                </li>
                                                <li><span class="offer-icon">
                                                        <i class="ri-discount-percent-fill"></i>
                                                    </span>
                                                    Limited Time Offer: 12% off
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal End -->

    <!-- Cart Offcanvas Start -->
    <div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title">My Cart @if(cart()->count() > 0) {{ '(' . cart()->count() . ')' }} @endif</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            {{--<div class="pre-text-box">
                <p>spend $20.96 More And Enjoy Free Shipping!</p>
                <div class="progress" role="progressbar">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 58.08%;">
                        <i class="ri-truck-line"></i>
                    </div>
                </div>
            </div>--}}

            <div class="sidebar-title">
                <a href="{{ route('purchase.clear-cart') }}">Clear Cart</a>
            </div>

            <div class="cart-media">
                <ul class="cart-product">
                    @forelse(cart()->all() as $key => $item)
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <a href="#!">
                                    <img src="{{ asset($item->options->item_img) }}" class="img-fluid" alt="Classic Jacket" style="width:calc(75px + 15 * (100vw - 320px) / 1600); object-fit: contain;">
                                </a>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ __($item->options->item_category) }}</h6>
                                <h4 class="mb-1 fw-bolder">{{ __($item->name) }}</h4>
                                <h5 class="mb-2">{{ __('MYR' . number_format($item->price, 2)) . ' x ' . __($item->quantity) }}</h5>
                                @if(isset($item->options->selected_options) && is_array($item->options->selected_options))
                                    <div class="d-flex">
                                        <div class="flex-grow-1 option-group mb-2">
                                            @foreach($item->options->selected_options as $option)
                                                <p class="mb-1"><strong>{{ $option->option_name }}:</strong> {{ $option->value_name }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(isset($item->options->option_groups) && is_array($item->options->option_groups))
                                    {{--This is the option is grouping--}}
                                    @foreach($item->options->option_groups as $groupKey => $group)
                                        <div class="d-flex">
                                            <div class="flex-grow-1 option-group mb-2">
                                                @foreach($group->options as $option)
                                                    <p class="mb-1"><strong>{{ $option->option_name }}:</strong> {{ $option->value_name }}</p>
                                                @endforeach
                                                @isset($group->quantity)
                                                <p class="mb-1"><strong>Quantity:</strong> {{ $group->quantity }}</p>
                                                @endisset
                                            </div>
                                            <div class="flex-shrink-0 offset-scriptnew offset-scriptnew2">
                                                <div class="close-circle">
                                                    <button class="close_button delete-button" onclick="event.preventDefault(); document.getElementById('remove-opt-group-{{ $item->id }}-{{ $groupKey }}').submit();">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                    <form id="remove-opt-group-{{ $item->id }}-{{ $groupKey }}" action="{{ route('purchase.remove-option-group', ['productId' => $item->id, 'groupKey' => $groupKey]) }}" method="POST">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex-shrink-0 offset-scriptnew">
                                <div class="close-circle">
                                    {{--<button class="close_button edit-button" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{!! route('purchase.options', $item->id) !!}" data-create-title="Edit Options">
                                        <i class="ri-pencil-line"></i>
                                    </button>--}}
                                    {{--<button class="close_button refresh-button">
                                        <i class="ri-refresh-line"></i>
                                    </button>--}}
                                    <button class="close_button delete-button" type="submit" onclick="event.preventDefault(); document.getElementById('remove-cart-item-{{ $key }}-{{ $item->id }}').submit();">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    <form id="remove-cart-item-{{ $key }}-{{ __($item->id) }}" action="{{ route('purchase.remove-from-cart', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li>
                        <h4 class="small mb-1">No items in cart</h4>
                    </li>
                    @endforelse
                </ul>

                <ul class="cart_total">
                    <li>
                        <div class="total">
                            <h5>Sub Total : <span>{{ __('MYR' . number_format(cart()->subtotal(), 2)) }}</span></h5>
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <a href="{{ route('purchase.cart') }}" class="btn view-cart">View Cart</a>
                            <a href="{{ route('purchase.checkout') }}" class="btn checkout">Check Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal fade theme-modal-2 variation-modal" id="variationModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ri-close-line"></i>
                </button>
                <div class="modal-body">
                    <div class="product-right product-page-details variation-title">
                        <h2 class="main-title">
                            <a href="product-page(accordian).html">Cami Tank Top (Blue)</a>
                        </h2>
                        <h3 class="price-detail">$14.25 <span>5% off</span></h3>
                    </div>
                    <div class="variation-box">
                        <h4 class="sub-title">Color:</h4>
                        <ul class="quantity-variant color">
                            <li class="bg-light">
                                <span style="background-color: rgb(240, 0, 0);"></span>
                            </li>
                            <li class="bg-light">
                                <span style="background-color: rgb(47, 147, 72);"></span>
                            </li>
                            <li class="bg-light active">
                                <span style="background-color: rgb(0, 132, 255);"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="variation-qty-button">
                        <div class="qty-section">
                            <div class="qty-box">
                                <div class="input-group qty-container">
                                    <button class="btn qty-btn-minus">
                                        <i class="ri-subtract-line"></i>
                                    </button>
                                    <input type="number" readonly name="qty" class="form-control input-qty" value="1">
                                    <button class="btn qty-btn-plus">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-buttons">
                            <button class="btn btn-animation btn-solid hover-solid scroll-button"
                                id="replacecartbtnVariation14" type="submit" data-bs-dismiss="modal">
                                <i class="ri-shopping-cart-line me-1"></i>
                                Update Item
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Offcanvas End -->


    <!-- tap to top start -->
    <div class="tap-top">
        <div>
            <i class="ri-arrow-up-double-line"></i>
        </div>
    </div>
    <!-- tap to top end -->


    <!-- Script -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>
    <script src="{{ asset('assets/js/price-range.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/slick-animation.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/fancyapps/fancybox.umd.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.vide.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/selectize/js/selectize.min.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/summernote/dist/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-setting.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom-slick-animated.js') }}"></script>

    <script src="{{ asset('assets/js/compare-class.js') }}"></script>
    <script src="{{ asset('apps/js/apps-script.js') }}"></script>

    @include(__('sweetalert::alert'))

    @stack('script')

    <script>
        $(window).on('load', function () {
            setTimeout(function () {
                $('#blackfriday').modal('show');
            }, 2500);
        });

        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }

        $(document).ready(function() {
            /*if (window.location.pathname !== '/') {*/
                function updateNewDiv() {
                    /*if ($(window).width() >= 768) {*/
                        // If new-div does not exist, create it
                        if ($('header.header-5').next('.new-div').length === 0) {
                            $('<div>', {
                                class: 'new-div',
                                css: {
                                    height: $('header.header-5').height()
                                }
                            }).insertAfter('header.header-5');
                        }
                        // Update the height on resize
                        $('.new-div').height($('header.header-5').height());
                    /*} else {*/
                        // Remove the new-div when the window is less than 760px wide
                        /*$('.new-div').remove();*/
                    /*}*/
                }

                // Initial check on document ready
                updateNewDiv();

                // Update on window resize
                $(window).on('resize', function() {
                    updateNewDiv();
                });
            /*}*/

            // Select the main logo and the footer logo
            var $brandLogo = $(".brand-logo.acemillia a img");
            var $footerLogo = $(".footer-content.acemillia-neuraloka-footer a img");

            // Store the default logo src values (for Dark Mode)
            var defaultBrandLogo = $brandLogo.attr("src");
            var defaultFooterLogo = $footerLogo.attr("src");

            // Function to update the active class on the theme switcher
            function updateActiveMode(mode) {
                $(".theme-switch-btn li").removeClass("active");
                $(".theme-switch-btn li").filter(function() {
                    return $(this).find("a").text().trim() === mode;
                }).addClass("active");
            }

            // On page load, apply the correct theme and logos based on localStorage
            if (localStorage.getItem("layout_version") === "dark") {
                $("body").addClass("dark");
                updateActiveMode("Dark Mode");
                // Use the default logos for Dark Mode
                $brandLogo.attr("src", defaultBrandLogo);
                $footerLogo.attr("src", defaultFooterLogo);
            } else {
                $("body").removeClass("dark");
                updateActiveMode("Light Mode");
                // In Light Mode, swap to the white mode logo using the data attribute
                $brandLogo.attr("src", $brandLogo.data("logo-white-mode"));
                $footerLogo.attr("src", $footerLogo.data("logo-white-mode"));
            }

            // Handle click events on the theme switcher links
            $(".theme-switch-btn li a").click(function(e) {
                e.preventDefault();  // Prevent the default anchor behavior

                var mode = $(this).text().trim();
                if (mode === "Dark Mode") {
                    $("body").addClass("dark");
                    localStorage.setItem("layout_version", "dark");
                    updateActiveMode("Dark Mode");
                    // Set logos to default (dark)
                    $brandLogo.attr("src", defaultBrandLogo);
                    $footerLogo.attr("src", defaultFooterLogo);
                } else if (mode === "Light Mode") {
                    $("body").removeClass("dark");
                    localStorage.removeItem("layout_version");
                    updateActiveMode("Light Mode");
                    // Set logos to the white mode versions
                    $brandLogo.attr("src", $brandLogo.data("logo-white-mode"));
                    $footerLogo.attr("src", $footerLogo.data("logo-white-mode"));
                }
            });
        });

    </script>

    <script>
        $(document).ready(function() {
            // Fix the outer container's height so that the layout remains steady.
            var bannerHeight = $('.banner-slider').height();
            $('.banner-slider').css('height', bannerHeight);

            // Capture the height of the "col-md-7" element, divide by 2, and apply to each home-banner > .col-12.
            /*var col7Height = $('.banner-slider .col-md-7').outerHeight();
            var halfHeight = col7Height / 2;
            $('.banner-slider .home-banner > .col-12').css('height', halfHeight + 'px');*/

            // Busy flag to avoid overlapping animations.
            var busy = false;

            // Helper: choose a random direction.
            function getRandomDirection() {
                var directions = ['up', 'down', 'left', 'right'];
                return directions[Math.floor(Math.random() * directions.length)];
            }

            // Slide out using CSS transform.
            function slideOutElement($el, direction, callback) {
                var duration = 500;
                // Capture and store original height and width if not already stored.
                var h = $el.data('origHeight');
                if (!h) {
                    h = $el.outerHeight();
                    $el.data('origHeight', h);
                }
                var w = $el.data('origWidth');
                if (!w) {
                    w = $el.outerWidth();
                    $el.data('origWidth', w);
                }
                $el.css('transition', 'transform ' + duration + 'ms ease');
                if (direction === 'up') {
                    $el.css('transform', 'translateY(-' + h + 'px)');
                } else if (direction === 'down') {
                    $el.css('transform', 'translateY(' + h + 'px)');
                } else if (direction === 'left') {
                    $el.css('transform', 'translateX(-' + w + 'px)');
                } else if (direction === 'right') {
                    $el.css('transform', 'translateX(' + w + 'px)');
                } else {
                    if (callback) callback();
                    return;
                }
                setTimeout(function() {
                    if (callback) callback();
                }, duration);
            }

            // Slide in using CSS transform.
            function slideInElement($el, direction, callback) {
                var duration = 500;
                var h = $el.data('origHeight');
                if (!h) {
                    h = $el.outerHeight();
                    $el.data('origHeight', h);
                }
                var w = $el.data('origWidth');
                if (!w) {
                    w = $el.outerWidth();
                    $el.data('origWidth', w);
                }
                // Remove any transition so we can set the starting transform.
                $el.css('transition', 'none');
                if (direction === 'up') {
                    $el.css('transform', 'translateY(' + h + 'px)');
                } else if (direction === 'down') {
                    $el.css('transform', 'translateY(-' + h + 'px)');
                } else if (direction === 'left') {
                    $el.css('transform', 'translateX(' + w + 'px)');
                } else if (direction === 'right') {
                    $el.css('transform', 'translateX(-' + w + 'px)');
                } else {
                    $el.css('transform', 'none');
                }
                // Force reflow to apply the starting transform.
                $el[0].offsetHeight;
                // Animate to the neutral position.
                $el.css('transition', 'transform ' + duration + 'ms ease');
                $el.css('transform', 'none');
                setTimeout(function() {
                    $el.css('transition', '');
                    // Reapply the original height so the full image is visible.
                    $el.css('height', h + 'px');
                    if (callback) callback();
                }, duration);
            }

            // Transformation A: Swap the two columns (col-md-7 and col-md-5) sequentially.
            function swapColumns(callback) {
                var col7 = $('.banner-slider .col-md-7');
                var col5 = $('.banner-slider .col-md-5');

                // Animate col7 first.
                var dir7 = getRandomDirection();
                slideOutElement(col7, dir7, function() {
                    // Toggle col7's order class.
                    if (col7.hasClass('order-md-1')) {
                        col7.removeClass('order-md-1').addClass('order-md-2');
                    } else {
                        col7.removeClass('order-md-2').addClass('order-md-1');
                    }
                    col7.css('transform', 'none');
                    slideInElement(col7, getRandomDirection(), function() {
                        // Then animate col5.
                        var dir5 = getRandomDirection();
                        slideOutElement(col5, dir5, function() {
                            if (col5.hasClass('order-md-2')) {
                                col5.removeClass('order-md-2').addClass('order-md-1');
                            } else {
                                col5.removeClass('order-md-1').addClass('order-md-2');
                            }
                            col5.css('transform','none');
                            slideInElement(col5, getRandomDirection(), callback);
                        });
                    });
                });
            }

            // Transformation B: Swap the two inner images in col-md-5 sequentially.
            function swapCol5Images(callback) {
                var items = $('.banner-slider .col-md-5 .home-banner > div');
                if (items.length < 2) { if (callback) callback(); return; }
                var first = $(items[0]);
                var second = $(items[1]);

                // Ensure default order classes.
                if (!first.hasClass('order-1') && !first.hasClass('order-2')) {
                    first.addClass('order-1');
                    second.addClass('order-2');
                }
                // Animate the first image.
                var dir1 = getRandomDirection();
                slideOutElement(first, dir1, function() {
                    if (first.hasClass('order-1')) {
                        first.removeClass('order-1').addClass('order-2');
                    } else {
                        first.removeClass('order-2').addClass('order-1');
                    }
                    first.css('transform','none');
                    slideInElement(first, getRandomDirection(), function() {
                        // Then animate the second image.
                        var dir2 = getRandomDirection();
                        slideOutElement(second, dir2, function() {
                            if (second.hasClass('order-2')) {
                                second.removeClass('order-2').addClass('order-1');
                            } else {
                                second.removeClass('order-1').addClass('order-2');
                            }
                            second.css('transform','none');
                            slideInElement(second, getRandomDirection(), callback);
                        });
                    });
                });
            }

            // Randomly choose one transformation to execute every 10 seconds.
            function randomizeLayout() {
                if (busy) return;
                busy = true;
                var transforms = [swapColumns, swapCol5Images];
                var chosen = transforms[Math.floor(Math.random() * transforms.length)];
                chosen(function() {
                    // After transformation finishes, add a random delay of 2 to 3 seconds before unlocking.
                    var delay = Math.floor(Math.random() * 1000) + 2000; // 2000-3000 ms delay
                    setTimeout(function() {
                        busy = false;
                    }, delay);
                });
            }

            setInterval(randomizeLayout, 10000);
        });
    </script>

</body>
</html>

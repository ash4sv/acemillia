<div class="acemillia-shop-product">
    <div class="row g-3 g-sm-4">
        @forelse($products as $key => $product)
            @php
                $url = route('web.shop.product', [
                    $menuSlug->slug,
                    $product->categories->pluck('slug')->first(),
                    $product->slug
                ]);
            @endphp
            <div class="col-xl-4 col-6 col-grid-box">
                <div class="basic-product theme-product-1">
                    <div class="overflow-hidden">
                        <div class="img-wrapper">
                            <a href="{!! $url !!}">
                                <img src="{{ asset($product->merged_images->first()) }}" class="w-100 img-fluid blur-up lazyload" alt="">
                            </a>
                            <div class="cart-info">
                                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                                    <i class="ri-heart-line"></i>
                                </a>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{!! route('web.shop.quickview', $product->slug) !!}" data-create-title="Quick View">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-detail">
                            <div>
                                <div class="brand-w-color">
                                    <a class="product-title" href="{!! $url !!}">{!! $product->name !!}</a>
                                </div>
                                <p>{!! Str::limit($product->product_description, 225, '...') !!}</p>
                                <h4 class="price">{{ $product->price }}</h4>
                            </div>
                            <ul class="offer-panel">
                                <li>
                                    <span class="offer-icon">
                                        <i class="ri-discount-percent-fill"></i>
                                    </span>
                                    {!! __('Limited Time Offer: 5% off') !!}
                                </li>
                                <li>
                                    <span class="offer-icon">
                                        <i class="ri-discount-percent-fill"></i>
                                    </span>
                                    {!! __('Limited Time Offer: 5% off') !!}
                                </li>
                                <li>
                                    <span class="offer-icon">
                                        <i class="ri-discount-percent-fill"></i>
                                    </span>
                                    {!! __('Limited Time Offer: 5% off') !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>{!! __('No products found.') !!}</p>
        @endforelse
    </div>
</div>

<script>
    console.log({!! $products->count() !!})
</script>

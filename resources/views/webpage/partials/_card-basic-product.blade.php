@php
    // Compute the product URL.
    // If you have a normalized URL on the product, use it.
    // Otherwise, fallback to generating using a default route structure.
    $url = $product->url ?? route('web.shop.product', [
        $menuSlug->slug ?? '',
        $product->categories->pluck('slug')->first() ?? '',
        $product->slug
    ]);

    // Extract min and max price (assumes the product has this attribute).
    [$minPrice, $maxPrice] = $product->min_max_price;

    // Generate a unique ID for dynamic elements (cart form and radio inputs).
    $uniqueId = $product->slug . '-' . $product->id;

    // Use a provided theme or the default 'theme-product-1'
    $themeClass = $theme ?? 'theme-product-1';
@endphp

<div class="basic-product {{ $themeClass }}">
    <div class="overflow-hidden">
        <div class="img-wrapper">
            <a href="{{ $url }}">
                <img src="{{ asset($product->merged_images->first() ?? $product->image) }}" class="w-100 img-fluid blur-up lazyload" alt="{{ $product->name }}">
            </a>
            {{-- Uncomment this section if you want to show ratings later --}}
            {{--
            <div class="rating-label">
                <i class="ri-star-fill"></i>
                <span>4.5</span>
            </div>
            --}}
            <div class="cart-info">
                <a href="#!" title="Add to Wishlist" class="wishlist-icon">
                    <i class="ri-heart-line"></i>
                </a>
                <a href="javascript:void(0);" onclick="event.preventDefault(); $('#add-to-cart-{{ $uniqueId }}').trigger('submit');">
                    <i class="ri-shopping-cart-line"></i>
                </a>
                <form class="shortcut-add-to-cart d-none" id="add-to-cart-{{ $uniqueId }}" action="{{ route('purchase.add-to-cart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product" value="{{ $product->id }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
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
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('web.shop.quickview', $product->slug) }}" data-create-title="Quick View">
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
                    <a class="product-title" href="{{ $url }}">
                        {!! $product->name !!}
                    </a>
                </div>
                {{-- Uncomment for extended description if needed --}}
                <p>{!! Str::limit($product->product_description, 225, '...') !!}</p>
                <h4 class="price">
                    @if(abs($minPrice - $maxPrice) < 0.0001)
                        {{ 'RM' . number_format($minPrice, 2) }}
                    @else
                        {{ 'RM' . number_format($minPrice, 2) }} - {{ 'RM' . number_format($maxPrice, 2) }}
                    @endif
                </h4>
            </div>
            <ul class="offer-panel">
                <li>
                    <span class="offer-icon"><i class="ri-discount-percent-fill"></i></span>
                    Limited Time Offer: 5% off
                </li>
                <li>
                    <span class="offer-icon"><i class="ri-discount-percent-fill"></i></span>
                    Limited Time Offer: 5% off
                </li>
                <li>
                    <span class="offer-icon"><i class="ri-discount-percent-fill"></i></span>
                    Limited Time Offer: 5% off
                </li>
            </ul>
        </div>
    </div>
</div>

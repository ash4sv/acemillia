<div class="theme-modal-2 variation-modal">
    <div class="product-right product-page-details variation-title">
        <h2 class="main-title">
            <a href="">{{ $existingItem->getName() }}</a>
        </h2>
        <h3 class="price-detail">{{ 'MYR' . number_format($existingItem->getPrice(), 2) }} {{--<span>5% off</span>--}}</h3>
    </div>

    @if($existingItem->getOptions() !== null)
        @foreach($existingItem->getOptions()['item_option'] as $optionSet)
            @foreach($optionSet as $opt)
                <p class="mb-1">{{ $opt['option_name'] }}: {{ $opt['value_name'] }}</p>
            @endforeach
        @endforeach
    @endif

    <div class="variation-qty-button">
        <div class="qty-section">
            <div class="qty-box">
                <div class="input-group qty-container">
                    <button class="btn qty-btn-minus"><i class="ri-subtract-line"></i></button>
                    <input type="text" readonly name="qty" class="form-control input-qty" value="{{ $existingItem->getQuantity() }}">
                    <button class="btn qty-btn-plus"><i class="ri-add-line"></i></button>
                </div>
            </div>
        </div>
        <div class="product-buttons">
            <button class="btn btn-animation btn-solid hover-solid scroll-button" id="replacecartbtnVariation14" type="submit" data-bs-dismiss="modal">
                <i class="ri-shopping-cart-line me-1"></i>
                Update Item
            </button>
        </div>
    </div>
</div>

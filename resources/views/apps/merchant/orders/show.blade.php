@extends('apps.layouts.shop-user-layout')

@push('script')
    <script>
        $(document).ready(function () {
            function showWizardStep(step) {
                const steps = ['shipping-form', 'making-order'];
                steps.forEach(s => $('.' + s).hide());
                $('.' + step).show();
                $('.wizard-form-header .nav-link').removeClass('active');
                $(`.wizard-form-header .nav-link[data-step="${step}"]`).addClass('active');
            }

            showWizardStep('shipping-form');

            $('#customPickToggle').on('change', function () {
                $('#customPickForm').toggle(this.checked);
            });

            // Store previous input values into memory on courier fetch
            let cachedShippingInput = {};

            function updateCourierDataAttributes() {
                let weight = $('#weight').val();
                let width = $('#width').val();
                let length = $('#length').val();
                let height = $('#height').val();

                cachedShippingInput = { weight, width, length, height };

                $('.fetch-courier').each(function () {
                    $(this).attr('data-weight', weight)
                        .attr('data-width', width)
                        .attr('data-length', length)
                        .attr('data-height', height);
                });
            }

            $('#weight, #width, #length, #height').on('keyup change', updateCourierDataAttributes);
            updateCourierDataAttributes();

            $('.fetch-courier').on('click', function () {
                let button = $(this);
                button.prop('disabled', true).text('Fetching...');

                let payload = {
                    pick_code: button.data('pick_code'),
                    pick_state: button.data('pick_state'),
                    pick_country: button.data('pick_country'),
                    send_code: button.data('send_code'),
                    send_state: button.data('send_state'),
                    send_country: button.data('send_country'),
                    weight: button.data('weight') || cachedShippingInput.weight,
                    width: button.data('width') || cachedShippingInput.width,
                    length: button.data('length') || cachedShippingInput.length,
                    height: button.data('height') || cachedShippingInput.height
                };

                $('input[name="weight"]').val(payload.weight);
                $('input[name="width"]').val(payload.width);
                $('input[name="length"]').val(payload.length);
                $('input[name="height"]').val(payload.height);
                $('input[name="pick_code"]').val(payload.pick_code);
                $('input[name="pick_state"]').val(payload.pick_state);
                $('input[name="pick_country"]').val(payload.pick_country);

                $.ajax({
                    url: '{{ route("merchant.couriers.fetch") }}',
                    type: 'POST',
                    data: payload,
                    success: function (response) {
                        if (response.success && response.couriers.length > 0) {
                            let table = `
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Courier</th>
                                    <th>Service Name</th>
                                    <th>Delivery Time</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${response.couriers.map(courier => `
                                    <tr>
                                        <td><img src="${courier.image}" class="img-fluid d-block mb-1 mx-auto">${courier.name}</td>
                                        <td>${courier.service_name}</td>
                                        <td>${courier.delivery_time}</td>
                                        <td>RM${courier.rate}</td>
                                        <td><a href="#" class="btn btn-sm btn-primary select-courier" data-courier-id="${courier.id}">Select</a></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                            $('.shipping-form').html(table);
                        } else {
                            $('.shipping-form').html(`<div class="alert alert-warning">No couriers found.</div>`);
                        }
                    },
                    error: function () {
                        $('.shipping-form').html(`<div class="alert alert-danger">Error fetching couriers.</div>`);
                    },
                    complete: function () {
                        button.prop('disabled', false).text('Select Courier');
                    }
                });
            });

            $(document).on('click', '.select-courier', function (e) {
                e.preventDefault();
                $('#selected_courier_id').val($(this).data('courier-id'));

                // Restore cached input values from memory
                $('input[name="weight"]').val(cachedShippingInput.weight);
                $('input[name="width"]').val(cachedShippingInput.width);
                $('input[name="length"]').val(cachedShippingInput.length);
                $('input[name="height"]').val(cachedShippingInput.height);

                showWizardStep('making-order');
            });

            $('.submit-order-courier').on('click', function () {
                const custom = $('#customPickToggle').is(':checked');
                let payload = {
                    courier_id: $('#selected_courier_id').val(),
                    weight: $('input[name="weight"]').val(),
                    width: $('input[name="width"]').val(),
                    length: $('input[name="length"]').val(),
                    height: $('input[name="height"]').val(),
                    content: $('input[name="content"]').val(),
                    value: $('input[name="value"]').val(),
                    collect_date: $('input[name="collect_date"]').val(),
                    sub_order_id: '{{ $subOrder->id }}',
                    pick_name: $('input[name="pick_name"]').val(),
                    pick_contact: $('input[name="pick_contact"]').val(),
                    pick_addr1: $('input[name="pick_addr1"]').val(),
                    pick_city: $('input[name="pick_city"]').val(),
                    pick_state: $('input[name="pick_state"]').val(),
                    pick_code: $('input[name="pick_code"]').val(),
                    pick_country: $('input[name="pick_country"]').val()
                };

                if (custom) {
                    payload.pick_name = $('input[name="custom_pick_name"]').val();
                    payload.pick_contact = $('input[name="custom_pick_contact"]').val();
                    payload.pick_addr1 = $('input[name="custom_pick_addr1"]').val();
                    payload.pick_city = $('input[name="custom_pick_city"]').val();
                    payload.pick_state = $('input[name="custom_pick_state"]').val();
                    payload.pick_code = $('input[name="custom_pick_code"]').val();
                    payload.pick_country = $('input[name="custom_pick_country"]').val();
                }

                if (!payload.value || isNaN(payload.value)) {
                    alert("Please enter a valid declared value.");
                    return;
                }

                $.post('{{ route("merchant.couriers.submit-order") }}', payload, function (res) {
                    if (res.success) {
                        alert('Shipment successfully created!');
                        // showWizardStep('airway-bill');
                    } else {
                        alert(res.error || 'Submission failed.');
                    }
                });
            });
        });
    </script>
@endpush

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="border border-solid p-sm-5 p-2">
            <div class="row">
                <div class="col-md-7">
                    <h3>Order ID : {!! $subOrder->order?->order_number ?? '' !!}</h3>
                </div>
                <div class="col-md-5">

                </div>
            </div>
            <div class="row g-sm-1 g-2 mb-sm-0 mb-2">
                <div class="col-md-3 col-12">
                    <div class="card my-sm-3 my-0">
                        <div class="card-body p-2 border border-light">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="ri-home-line bg-pending"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">Order made</p>
                                    <p class="small fw-light mb-0">Create order</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card my-sm-3 my-0">
                        @php
                            $paymentStatus = $subOrder->order->payment_status;

                            $paymentStatusClassMap = [
                                'pending' => 'bg-pending',
                                'paid'    => 'bg-credit',
                                'failed'  => 'bg-debit',
                            ];
                            $paymentStatusClass = $paymentStatusClassMap[$paymentStatus] ?? 'bg-default';
                            $paymentStatusLabel = ucfirst($paymentStatus);

                            $paymentStatusSubLabels = [
                                'pending' => 'Awaiting Payment Confirmation',
                                'paid'    => 'Payment Completed',
                                'failed'  => 'Payment Failed',
                            ];
                            $paymentBorderColors = [
                                'pending' => 'border-light',
                                'paid'    => 'border-success',
                                'failed'  => 'border-danger',
                            ];
                            $paymentIconLabels = [
                                'pending' => 'ri-loader-3-line',
                                'paid'    => 'ri-check-line',
                                'failed'  => 'ri-close-large-line',
                            ];

                            $paymentStatusSubLabel = $paymentStatusSubLabels[$paymentStatus] ?? 'Test';
                            $paymentBorderColor    = $paymentBorderColors[$paymentStatus] ?? 'border-light';
                            $paymentIconLabel      = $paymentIconLabels[$paymentStatus] ?? 'Test';
                        @endphp
                        <div class="card-body p-2 border {{ $paymentBorderColor }}">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center text-sm-start">
                                    <i class="{{ $paymentIconLabel }} {{ $paymentStatusClass }}"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2 text-sm-start">
                                    <p class="fw-bold mb-1">{{ $paymentStatusLabel }}</p>
                                    <p class="small fw-light mb-0">{{ $paymentStatusLabel }}s</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center text-sm-start">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card my-sm-3 my-0">
                        @php
                            $shippingStatus = $subOrder->shipping_status;

                            $shippingStatusClassMap = [
                                'pending'   => 'bg-pending',
                                'shipped'   => 'bg-credit',
                                'delivered' => 'bg-completed',
                                'cancelled' => 'bg-debit',
                            ];
                            $shippingStatusClass = $shippingStatusClassMap[$shippingStatus] ?? 'bg-default';
                            $shippingStatusLabel = ucfirst($shippingStatus);

                            $shippingStatusSubLabels = [
                                'pending'   => 'Awaiting Shipment',
                                'shipped'   => 'On the Way',
                                'delivered' => 'Delivered Successfully',
                                'cancelled' => 'Shipment Cancelled',
                            ];
                            $shippingBorderColors = [
                                'pending'   => 'border-light',
                                'shipped'   => 'border-primary',
                                'delivered' => 'border-success',
                                'cancelled' => 'border-danger',
                            ];
                            $shippingIconLabels = [
                                'pending'   => 'ri-list-check-3',
                                'shipped'   => 'ri-truck-line',
                                'delivered' => 'ri-check-line',
                                'cancelled' => 'ri-close-large-line',
                            ];

                            $shippingStatusSubLabel = $shippingStatusSubLabels[$shippingStatus] ?? 'Test';
                            $shippingBorderColor    = $shippingBorderColors[$shippingStatus] ?? 'border-light';
                            $shippingIconLabel      = $shippingIconLabels[$shippingStatus] ?? 'Test';
                        @endphp
                        <div class="card-body p-2 border {{ $shippingBorderColor }}">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="{{ $shippingIconLabel }} {{ $shippingStatusClass }}"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">{{ $shippingStatusLabel }}</p>
                                    <p class="small fw-light mb-0">{{ $shippingStatusSubLabel }}</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card my-sm-3 my-0">
                        @php
                            $paymentStatus = $subOrder->order->payment_status;
                            $shippingStatus = $subOrder->shipping_status;

                            $orderComplete = ($paymentStatus === 'paid' && $shippingStatus === 'delivered');

                            $cardStatus  = $orderComplete ? 'Complete' : 'In Progress';
                            $cardMessage = $orderComplete ? 'Order completed' : 'Order in progress';

                            $cardIconLabels = [
                                 'Complete'    => 'ri-check-double-line',  // e.g., icon for complete order
                                 'In Progress' => 'ri-progress-5-line',       // e.g., icon for in-progress order  < i class=""></i>
                            ];

                            $orderBorderColors = [
                                'Complete'    => 'border-success',
                                'In Progress' => 'border-light',
                            ];

                            $cardIconClassMapping = [
                                 'Complete'    => 'bg-completed',  // your complete order icon style
                                 'In Progress' => 'bg-pending',    // your in progress order icon style
                            ];

                            $orderIconLabel = $cardIconLabels[$cardStatus] ?? 'Test';
                            $orderBorderColor = $orderBorderColors[$cardStatus] ?? 'border-light';
                            $cardIconClass = $cardIconClassMapping[$cardStatus] ?? 'bg-default';
                        @endphp
                        <div class="card-body p-2 border {{ $orderBorderColor }}">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="{{ $orderIconLabel }} {{ $cardIconClass }}"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">{{ $cardStatus }}</p>
                                    <p class="small fw-light mb-0">{{ $cardMessage }}</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-solid p-4">
                <div class="row">
                    <div class="col-md-6 order-detail">
                        @isset($subOrder->order->billingAddress)
                            @php($b = $subOrder->order?->billingAddress)
                            <h3 class="fw-bold">{!! __('Billing Address') !!}</h3>
                            <p class="fw-semibold">{!! $b->recipient_name !!}</p>
                            <p>{!! $b->street_address !!}, {!! $b->address !!}</p>
                            <p>{!! $b->postcode !!}, {!! $b->city !!}</p>
                            <p>{!! $b->state !!}, {!! $b->country !!}</p>
                            <p>{!! $b->phone !!}</p>
                        @endisset
                    </div>
                    <div class="col-md-6 order-detail">
                        @isset($subOrder->order->shippingAddress)
                            @php($s = $subOrder->order?->shippingAddress)
                            <h3 class="fw-bold">{!! __('Shipping Address') !!}</h3>
                            <p class="fw-semibold">{!! $s->recipient_name !!}</p>
                            <p>{!! $s->street_address !!}, {!! $s->address !!}</p>
                            <p>{!! $s->postcode !!}, {!! $s->city !!}</p>
                            <p>{!! $s->state !!}, {!! $s->country !!}</p>
                            <p>{!! $s->phone !!}</p>
                        @endisset
                    </div>
                </div>


                <hr class="py-0">

                <!-- Order‑detail card -->
                <div class="order-detail-item p-3 mb-3">
                    @forelse($subOrder->items as $i => $item)
                    <div class="order-itemize d-flex align-items-stretch w-100">
                        <div class="order-item-img flex-shrink-0 me-3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                        </div>

                        <div class="order-item-description flex-grow-1">
                            <p class="mb-1 text-muted">Jacket</p>
                            <h3 class="h5 fw-medium mb-1">{!! $item->product_name !!}</h3>
                            <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                        </div>

                        <div class="order-item-price flex-shrink-0 text-end ms-auto">
                            <p class="mb-0">{!! 'RM' . number_format($item->price_with_commission, 2) !!} &nbsp;<span class="text-muted"> × {!! $item->quantity !!}</span></p>
                        </div>
                    </div>
                    @empty
                    <div class="order-itemize d-flex align-items-stretch w-100">
                        <div class="flex-grow-1 text-center py-5">
                            <h3 class="m-0 text-center">
                                No valid items found for this order — they may have been removed or never existed.
                            </h3>
                        </div>
                    </div>
                    @endforelse
                </div>

                <hr class="py-0 mt-0">

                <h4 class="mb-4">Order Summary</h4>
                <div class="single-cart-item d-flex align-items-stretch mb-2">
                    <div class="box flex-shrink-0">
                        <h4 class="fw-medium">Total Sales</h4>
                    </div>
                    <div class="box flex-grow-1">

                    </div>
                    <div class="box flex-shrink-0 text-end">
                        <h4 class="fw-medium">RM{{ number_format($subOrder->subtotal_with_commission, 2) }}</h4>
                    </div>
                </div>
                <div class="single-cart-item d-flex align-items-stretch mb-2">
                    <div class="box flex-shrink-0">
                        <h4 class="fw-medium">Commission <small class="text-muted">({{ config('commission.rate') . '%' }})</small></h4>
                    </div>
                    <div class="box flex-grow-1">

                    </div>
                    <div class="box flex-shrink-0 text-end">
                        <h4 class="fw-medium">RM{{ number_format($subOrder->commission_amount, 2) }}</h4>
                    </div>
                </div>
                <div class="single-cart-item d-flex align-items-stretch">
                    <div class="box flex-shrink-0">
                        <h4 class="fw-medium">Total</h4>
                    </div>
                    <div class="box flex-grow-1">

                    </div>
                    <div class="box flex-shrink-0 text-end">
                        <h4 class="fw-medium">RM{{ number_format($subOrder->subtotal_with_commission - $subOrder->commission_amount, 2) }}</h4>
                    </div>
                </div>
            </div>

            <div class="border border-solid p-4 mt-3">

                <div class="card mt-0 mb-4 wizard-form-header">
                    <div class="card-body p-2">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link py-3 rounded-0" href="#" data-step="shipping-form">Select Courier</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 rounded-0" href="#" data-step="making-order">Shipment Creation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 rounded-0" href="#" data-step="airway-bill">Airway Bill Generation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 rounded-0" href="#" data-step="pickup-scheduling">Pickup Scheduling</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="wizard-content">
                    <div class="shipping-form">
                        <div class="row gx-3">
                            <div class="col-5">
                                <div class="mb-2">
                                    <div class="input-group">
                                        <input type="text" name="weight" id="weight" value="{{ $subOrder->totalWeight()  }}" placeholder="Weight" class="form-control" aria-label="Weight" aria-describedby="weight weight2">
                                        <span style="width:60px;" class="input-group-text" id="weight">kg</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="input-group">
                                        <input type="text" name="width" id="width" value="" placeholder="Width" class="form-control" aria-label="Width" aria-describedby="width width2">
                                        <span style="width:60px;" class="input-group-text" id="width">cm</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="input-group">
                                        <input type="text" name="length" id="length" value="" placeholder="Length" class="form-control" aria-label="Length" aria-describedby="length length2">
                                        <span style="width:60px;" class="input-group-text" id="length">cm</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="input-group">
                                        <input type="text" name="height" id="height" value="" placeholder="Height" class="form-control" aria-label="Height" aria-describedby="height height2">
                                        <span style="width:60px;" class="input-group-text" id="height">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                * Notes

                            </div>
                        </div>
                        @php($send = $subOrder->order?->shippingAddress)
                        @php($pick = auth()->guard('web')->user())
                        <button type="button"
                                data-pick_code="{{ $authUser->address?->postcode }}"
                                data-pick_state="{{ $authUser->address?->state }}"
                                data-pick_country="{{ $authUser->address?->country }}"
                                data-send_code="{{ $send->postcode ?? '' }}"
                                data-send_state="{{ $send->state ?? '' }}"
                                data-send_country="{{ $send->country ?? '' }}"
                                data-weight=""
                                data-width=""
                                data-length=""
                                data-height=""
                                class="btn btn-primary px-5 py-3 fetch-courier">
                            Select Courier
                        </button>
                    </div>

                    {{-- Store selected courier and shipment metadata --}}
                    <input type="hidden" id="selected_courier_id" name="courier_id">
                    <input type="hidden" name="weight">
                    <input type="hidden" name="width">
                    <input type="hidden" name="length">
                    <input type="hidden" name="height">

                    {{-- Default Pickup Address (from merchant address) --}}
                    <input type="hidden" name="pick_name" value="{{ $authUser->name }}">
                    <input type="hidden" name="pick_contact" value="{{ $authUser->phone }}">
                    <input type="hidden" name="pick_addr1" value="{{ $authUser->address->business_address }}">
                    <input type="hidden" name="pick_addr2" value="{{ $authUser->address->street_address }}">
                    <input type="hidden" name="pick_city" value="{{ $authUser->address->city }}">
                    <input type="hidden" name="pick_state" value="{{ $authUser->address->state }}">
                    <input type="hidden" name="pick_code" value="{{ $authUser->address->postcode }}">
                    <input type="hidden" name="pick_country" value="{{ $authUser->address->country }}">

                    {{-- Editable pickup address toggle --}}
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="customPickToggle">
                        <label class="form-check-label" for="customPickToggle">Ship from different pickup address</label>
                    </div>

                    {{-- Editable Pickup Form (hidden by default) --}}
                    <div class="row" id="customPickForm" style="display: none;">
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" placeholder="Pickup Name" name="custom_pick_name">
                            <input type="text" class="form-control mb-2" placeholder="Pickup Contact" name="custom_pick_contact">
                            <input type="text" class="form-control mb-2" placeholder="Pickup Address" name="custom_pick_addr1">
                            <input type="text" class="form-control mb-2" placeholder="Pickup City" name="custom_pick_city">
                            <input type="text" class="form-control mb-2" placeholder="Pickup State" name="custom_pick_state">
                            <input type="text" class="form-control mb-2" placeholder="Pickup Postcode" name="custom_pick_code">
                            <input type="text" class="form-control mb-2" placeholder="Pickup Country" name="custom_pick_country">
                        </div>
                    </div>

                    {{-- Shipment Form --}}
                    <div class="making-order">
                        <div class="row gx-3">
                            <div class="col-5">
                                <div class="mb-2">
                                    <input type="text" name="content" class="form-control" placeholder="Content" maxlength="35">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="value" class="form-control" placeholder="Value">
                                </div>
                                <div class="mb-2">
                                    <input type="date" name="collect_date" class="form-control" placeholder="Collect date">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary px-5 py-3 submit-order-courier">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

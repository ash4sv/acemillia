{{-- Customer & Dates --}}
<div class="row mb-3">
    <div class="col-md-6">
        <p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
    </div>
    <div class="col-md-6 text-md-end">
        <p>
            <strong>Status:</strong>
            <span class="badge
          {{ $order->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
          {{ strtoupper($order->status) }}
        </span>
        </p>
    </div>
</div>

<!-- STEP 1: Timeline as a linear stepper -->
<div class="py-2 mb-2 bg-label-primary text-white text-center rounded-2 flex-grow-1">Timeline</div>
<div class="mb-4">
    <div class="ordertime-steps">
        @foreach($order->timeline_events as $event)
            <div class="ordertime-step {{ $event['class'] }}">
                <div class="ordertime-content">
                    <div class="ordertime-inner-circle">
                        <i class="{{ $event['icon'] }}"></i>
                    </div>
                    <p class="h6 mt-3 mb-1">
                        {{ \Carbon\Carbon::parse($event['date'])->format('d-m-Y') }}
                    </p>
                    <p class="h6 text-muted mb-0 mb-lg-0">{{ $event['label'] }}</p>
                    @if(!empty($event['details']))
                        @foreach($event['details'] as $line)
                            <p class="h6 text-muted mb-0 mb-lg-0">{{ $line }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- End Stepper -->

{{-- Addresses --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="py-2 mb-2 bg-label-primary text-white text-center rounded-2 flex-grow-1">Billing Address</div>
        <address class="mb-0 address-item">
            <strong>{{ $order->billingAddress->recipient_name ?? '--' }}</strong><br>
            {{ $order->billingAddress->phone ?? '--' }}<br>
            {{ $order->billingAddress->address ?? '--' }}<br>
            {{ $order->billingAddress->postcode ?? '--' }},
            <span data-address-city="{!! $order->shippingAddress->city ?? '--' !!}"></span>,  <br>
            <span data-address-state="{!! $order->shippingAddress->state ?? '--' !!}"></span>,
            <span data-address-country="{!! $order->shippingAddress->country ?? '--' !!}"></span>
        </address>
    </div>
    <div class="col-md-6">
        <div class="py-2 mb-2 bg-label-primary text-white text-center rounded-2 flex-grow-1">Shipping Address</div>
        <address class="mb-0 address-item">
            <strong>{{ $order->shippingAddress->recipient_name }}</strong><br>
            {{ $order->shippingAddress->phone }}<br>
            {{ $order->shippingAddress->address }}<br>
            {{ $order->shippingAddress->postcode }},
            <span data-address-city="{!! $order->shippingAddress->city !!}"></span>, <br>
            <span data-address-state="{!! $order->shippingAddress->state !!}"></span>,
            <span data-address-country="{!! $order->shippingAddress->country !!}"></span>
        </address>
    </div>
</div>

{{-- Items --}}
<div class="py-2 mb-2 bg-label-primary text-white text-center rounded-2 flex-grow-1">Order Items</div>
<table class="table table-sm table-striped mb-4">
    <thead>
    <tr>
        <th class="px-0 py-2">Product</th>
        <th class="px-0 py-2">Options</th>
        <th class="px-0 py-2 text-center">Qty</th>
        <th class="px-0 py-2 text-end">Price</th>
        <th class="px-0 py-2 text-end">Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->subOrders as $sub)
        @foreach($sub->items as $item)
            @php($opts = json_decode($item->options, true) ?: [])
            <tr>
                <td class="px-0">{{ $item->product_name }}</td>
                <td class="px-0">
                    {{--@if(! empty($opts['selected_options']))
                        {{ collect($opts['selected_options'])
                            ->map(fn($o) => "{$o['name']}: {$o['value']}")
                            ->implode(', ') }}
                    @else
                        —
                    @endif--}}
                </td>
                <td class="text-center px-0">{{ $item->quantity }}</td>
                <td class="text-end px-0">RM{{ number_format($item->price_with_commission, 2) }}</td>
                <td class="text-end px-0">
                    RM{{ number_format($item->price_with_commission * $item->quantity, 2) }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" class="text-end px-0">Merchandise Subtotal</td>
        <td class="text-end px-0">RM{{ number_format($order->merchandise_subtotal, 2) }}</td>
    </tr>
    <tr>
        <td colspan="4" class="text-end px-0">Shipping Fee</td>
        <td class="text-end px-0">RM{{ number_format($order->shipping_fee, 2) }}</td>
    </tr>
    <tr>
        <td colspan="4" class="text-end px-0">Admin Commission</td>
        <td class="text-end px-0">RM{{ number_format($order->admin_commission, 2) }}</td>
    </tr>
    <tr class="fw-bold">
        <td colspan="4" class="text-end px-0">Total</td>
        <td class="text-end text-danger px-0">{{ $order->total_amount }}</td>
    </tr>
    </tfoot>
</table>

{{-- Payment --}}
<div class="mb-3 d-flex align-items-center">
    <div class="py-2 bg-label-primary text-white text-center rounded-2 flex-grow-1 me-1">Payment</div>
    <a href="{{ asset('assets/upload/pdf/RECEIPT-' . $order->order_number . '.pdf')  }}" target="_blank" class="btn btn-secondary me-1">Download Receipt</a>
    <button type="button"
        data-generate-url="{{ route('admin.shipping-service.generate.receipt') }}"
        data-order="{{ $order->id }}"
        class="btn btn-primary generate-receipt">
            Generate Receipt
    </button>
</div>
<ul class="list-unstyled mb-4">
    <li><strong>Gateway:</strong> {{ $order->payment->gateway ?? '–' }}</li>
    <li><strong>Reference:</strong> {{ $order->payment->reference_id ?? '–' }}</li>
    <li>
        <strong>Paid At:</strong>
        {{ optional($order->payment->paid_at)->format('d-m-Y H:i') ?? '–' }}
    </li>
    <li>
        <strong>Amount:</strong>
        RM{{ number_format($order->payment->amount ?? 0, 2) }}
    </li>
    <li>
        <strong>Status:</strong>
        {{ ucfirst($order->payment->status ?? 'pending') }}
    </li>
</ul>

{{-- Shipments --}}
<div class="py-2 mb-2 bg-label-primary text-white text-center rounded-2 flex-grow-1">Shipments</div>
<table class="table table-sm table-striped mb-0">
    <thead>
    <tr>
        <th class="px-0 py-2">SubOrder ID</th>
        <th class="px-0 py-2">Merchant</th>
        <th class="px-0 py-2">Courier</th>
        <th class="px-0 py-2">AWB #</th>
        <th class="px-0 py-2">Status</th>
        <th class="px-0 py-2">Pickup</th>
        <th class="px-0 py-2">Delivery</th>
        <th class="px-0 py-2">PO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->subOrders as $sub)
        <tr>
            <td class="px-0">{{ $sub->id }}</td>
            <td class="px-0">
                {{ $sub->merchant?->name ?? '–' }}
            </td>
            <td class="px-0">
                {{ $sub->shipment?->courier?->name ?? '–' }}
            </td>
            <td class="px-0">
                {{ $sub->shipment?->tracking_number ?? '–' }}
            </td>
            <td class="px-0">
                {{ ucfirst($sub->shipment?->status ?? '–') }}
            </td>
            <td class="px-0">
                {{ $sub->shipment?->pickup_date?->format('d-m-Y') ?? '–' }}
            </td>
            <td class="px-0">
                {{ $sub->shipment?->delivery_date?->format('d-m-Y') ?? '–' }}
            </td>
            <td class="px-0">
                <a target="_blank" href="{{ asset($sub->purchase_order) ?? '–' }}">{{ $sub->po_number ?? '–' }}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(function() {
        window.CountryMap           = @json(\App\Services\LocationService::countries()->toArray());
        $('.generate-receipt').on('click', function(e) {
            e.preventDefault();
            const btn   = $(this);
            const url   = btn.data('generate-url');
            const order = btn.data('order');

            // Disable & show loading text
            btn.prop('disabled', true).text('Generating…');

            $.post(url, { order })
                .done(function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Receipt Generated!',
                            text: 'Your PDF receipt will download shortly.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Trigger automatic download
                            const a = document.createElement('a');
                            a.href = res.pdf_url;
                            a.download = res.filename;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Failed to generate receipt.', 'error');
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Server error';
                    Swal.fire('Error', msg, 'error');
                })
                .always(function() {
                    btn.prop('disabled', false).text('Generate Receipt');
                });
        });
    });
</script>
<script src="{{ asset('assets_v2/js/location-services.js') }}"></script>

@php
    $route = 'admin.order.';
@endphp

<form action="{{ isset($order) ? route( $route . 'update', $order->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($order))
        @method('PUT')
    @endif

    {{-- Order-level status --}}
    <div class="mb-3">
        <label class="form-label">Order Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach(['processing', 'completed','cancelled'] as $st)
                <option value="{{ $st }}" {{ old('status', $order->status) === $st ? 'selected' : '' }}>
                    {{ ucfirst($st) }}
                </option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <hr>

    @foreach($order->subOrders as $sub)

        <fieldset class="border p-3 mb-4">
            <legend class="float-none w-auto px-2 mb-0">SubOrder #{{ $sub->id }}</legend>

            {{-- Merchant --}}
            <div class="mb-3">
                <label for="merchant" class="form-label">Merchant</label>
                <div class="input-group">
                    <input type="text" name="merchant" id="merchant" class="form-control" readonly value="{{ $sub->merchant->name }}">
                    @isset($sub->purchase_order)
                        <a href="{{ asset($sub->purchase_order) }}" class="btn btn-outline-primary" target="_blank">Download P.O</a>
                    @endisset
                    <button class="btn btn-outline-primary generate-purchase-order" type="button" id="supplier-addon"
                        data-generate-url="{{ route('admin.shipping-service.generate.po') }}"
                        data-merchant="{{ $sub->merchant->id }}"
                        data-order="{{ $order->id }}"
                        data-sub-order="{{ $sub->id }}">
                            Generate P.O
                    </button>
                </div>
            </div>

            {{-- Items List --}}
            <div class="mb-3">
                <label class="form-label">Items in this SubOrder</label>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="px-0 py-2">Product</th>
                            <th class="px-0 py-2">Variation</th>
                            <th class="px-0 py-2 text-center">Qty</th>
                            <th class="px-0 py-2 text-end">Unit Price</th>
                            <th class="px-0 py-2 text-end">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sub->items as $item)
                            {{--@php
                                $opts = json_decode($item->options, true) ?: [];
                                $variation = collect($opts['selected_options'] ?? [])
                                  ->map(fn($o) => "{$o['name']}: {$o['value']}")
                                  ->implode(', ');
                            @endphp--}}
                            <tr>
                                <td class="px-0">{{ $item->product_name }}</td>
                                <td class="px-0">{{--{{ $variation ?: '—' }}--}}</td>
                                <td class="px-0 text-center">{{ $item->quantity }}</td>
                                <td class="px-0 text-end">RM{{ number_format($item->price, 2) }}</td>
                                <td class="px-0 text-end">
                                    RM{{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SubOrder shipping_status --}}
            <div class="mb-3">
                <label class="form-label">SubOrder Status</label>
                <select name="sub_orders[{{ $sub->id }}][shipping_status]" class="form-select @error("sub_orders.$sub->id.shipping_status") is-invalid @enderror" >
                    @foreach(['pending','shipped','delivered'] as $ss)
                        <option value="{{ $ss }}" {{ old("sub_orders.$sub->id.shipping_status", $sub->shipping_status) === $ss ? 'selected' : '' }}>
                            {{ ucfirst($ss) }}
                        </option>
                    @endforeach
                </select>
                @error("sub_orders.$sub->id.shipping_status")
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Shipment fields --}}
            @php $sh = $sub->shipment @endphp

            <div class="row gx-3">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Courier</label>
                    <select
                        name="sub_orders[{{ $sub->id }}][shipment][courier_id]"
                        class="form-select @error("sub_orders.$sub->id.shipment.courier_id") is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach($couriers as $c)
                            <option
                                value="{{ $c->id }}"
                                {{ old("sub_orders.$sub->id.shipment.courier_id", $sh?->courier_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    @error("sub_orders.$sub->id.shipment.courier_id")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tracking #</label>
                    <input
                        type="text"
                        name="sub_orders[{{ $sub->id }}][shipment][tracking_number]"
                        value="{{ old("sub_orders.$sub->id.shipment.tracking_number", $sh?->tracking_number) }}"
                        class="form-control @error("sub_orders.$sub->id.shipment.tracking_number") is-invalid @enderror" >
                    @error("sub_orders.$sub->id.shipment.tracking_number")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">AWB URL</label>
                    <input
                        type="url"
                        name="sub_orders[{{ $sub->id }}][shipment][awb_url]"
                        value="{{ old("sub_orders.$sub->id.shipment.awb_url", $sh?->awb_url) }}"
                        class="form-control @error("sub_orders.$sub->id.shipment.awb_url") is-invalid @enderror" >
                    @error("sub_orders.$sub->id.shipment.awb_url")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pickup Date</label>
                    <input
                        type="date"
                        name="sub_orders[{{ $sub->id }}][shipment][pickup_date]"
                        value="{{ old("sub_orders.$sub->id.shipment.pickup_date", $sh?->pickup_date->format('Y-m-d')) }}"
                        class="form-control @error("sub_orders.$sub->id.shipment.pickup_date") is-invalid @enderror" >
                    @error("sub_orders.$sub->id.shipment.pickup_date")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Delivery Date</label>
                    <input
                        type="date"
                        name="sub_orders[{{ $sub->id }}][shipment][delivery_date]"
                        value="{{ old("sub_orders.$sub->id.shipment.delivery_date", optional($sh?->delivery_date)->format('Y-m-d')) }}"
                        class="form-control @error("sub_orders.$sub->id.shipment.delivery_date") is-invalid @enderror" >
                    @error("sub_orders.$sub->id.shipment.delivery_date")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </fieldset>
    @endforeach

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($order) ? 'Update' : 'Create' }} Order</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

<script>
    $(function() {
        // Attach handler to each button with .generate-purchase-order
        $('.generate-purchase-order').each(function() {
            const btn = $(this);

            btn.on('click', function(e) {
                e.preventDefault();

                // Read data attributes
                const url      = btn.data('generate-url');
                const merchant = btn.data('merchant');
                const order    = btn.data('order');
                const subOrder = btn.data('sub-order');

                // Disable & show loading
                btn.prop('disabled', true).text('Generating…');

                $.post(url, { merchant, order, sub_order: subOrder })
                    .done(function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: `PO ${res.po_number} Generated!`,
                                text: 'Your purchase order PDF will download shortly.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // auto-download the PDF
                                const link = document.createElement('a');
                                link.href = res.pdf_url;
                                link.download = `${res.po_number}.pdf`;
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            });
                        } else {
                            Swal.fire('Error', 'Failed to generate P.O.', 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const msg = xhr.responseJSON?.message || 'Server error';
                        Swal.fire('Error', msg, 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).text('Generate P.O');
                    });
            });
        });
    });
</script>


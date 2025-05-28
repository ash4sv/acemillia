{{-- resources/views/apps/user/purchase/purchase-receipt.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Purchase Order {{ $order->order_number }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('apps/img/favicon/favicon.ico') }}" type="image/x-icon" />

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 0;
            border: 0;
            font-size: 12px;
            line-height: 20px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 5px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 16px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 5px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(6) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .invoice-box ol.noted-printer {
            text-align: left;
            margin: 0;
            padding-left: 1.5rem;
        }
        .invoice-box ol.noted-printer li {
            margin-left: 0;
            padding-left: 0;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td,
            .invoice-box table tr.information table td {
                display: block;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table>
        {{-- Header --}}
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td class="title" style="text-align:left;">
                            <img src="{{ 'data:image/png;base64,' . base64_encode( file_get_contents( asset('assets/images/logo-neuraloka_black_admin.png') ) ) }}" alt="Logo" style="width:100%; max-width:200px; margin-bottom: 10px;"><br>
                            Order Number: {{ $order->order_number }}<br>
                            Date: {{ $date }}
                        </td>
                        <td style="text-align: right;">
                            <h1>Receipt</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Supplier & Company Info --}}
        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="50%" style="text-align:left;">
                            <div class="address-item">
                                <strong>From:</strong><br>
                                Tekadex by Ardia Nexus Enterprise<br>
                                28-1, Jalan Sierra 10/3, Bandar 16 Sierra,<br>
                                47120 Puchong, Selangor, Malaysia<br>
                                www.tekad.my | info@tekad.com | +6017 670 5705
                            </div>
                        </td>
                        <td width="50%">
                            <div class="address-item">
                                {{-- blank cell or additional header --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <div class="address-item">
                                <strong>Shipping Address:</strong><br>
                                {{ $shippingAddress['recipient_name'] }}<br>
                                {{ $shippingAddress['address'] }}<br>
                                {{ $shippingAddress['postcode'] }}, {{ $shippingAddress['city'] }}<br>
                                {{ $shippingAddress['state'] }}, {{ $shippingAddress['country'] }}<br>
                                Tel: {{ $shippingAddress['phone'] }}
                            </div>
                        </td>
                        <td width="50%">
                            <div class="address-item">
                                <strong>Billing Address:</strong><br>
                                {{ $billingAddress['recipient_name'] }}<br>
                                {{ $billingAddress['address'] }}<br>
                                {{ $billingAddress['postcode'] }}, {{ $billingAddress['city'] }}<br>
                                {{ $billingAddress['state'] }}, {{ $billingAddress['country'] }}<br>
                                Tel: {{ $billingAddress['phone'] }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Items --}}
        <tr class="heading">
            <td>Item</td>
            <td colspan="2">Variation</td>
            <td style="text-align: center;">Qty</td>
            <td style="text-align:right;">Unit Price</td>
            <td style="text-align:right;">Total</td>
        </tr>

        @foreach($items as $item)
            {{--@php
                $opts = json_decode($item->options, true) ?: [];
                $variation = collect($opts['selected_options'] ?? [])
                    ->map(fn($o) => "{$o['name']}: {$o['value']}")
                    ->implode(', ');
            @endphp--}}
            <tr class="item">
                <td>{{ $item->product->name ?? $item->product_name }}</td>
                <td colspan="2">{{--{{ $variation ?: '–' }}--}}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align:right;">RM{{ number_format($item->price, 2) }}</td>
                <td style="text-align:right;">RM{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach

        {{-- Totals --}}
        <tr class="total">
            <td colspan="4"></td>
            <td style="text-align:right;"><strong>Sub-Total:</strong></td>
            <td style="text-align:right;">RM{{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr class="total">
            <td colspan="4"></td>
            <td style="text-align:right;"><strong>Total:</strong></td>
            <td style="text-align:right;">{{ $total }}</td>
        </tr>
    </table>

    {{-- Terms & Conditions --}}
    <h4 style="text-align:left; margin:1rem 0 0.5rem;">Terms &amp; Conditions:</h4>
    <ol class="noted-printer">
        <li>The quotation is valid for 23 days from the date above.</li>
        <li>All prices are in Malaysian Ringgit (MYR).</li>
        <li>Once the client agrees, please sign and return the quotation.</li>
        <li>Contact Muhamad Ashraf bin Abdullah at 017-571 3297 for inquiries.</li>
        <li>Tekadex may modify terms without prior notice; changes will be communicated.</li>
        <li>These terms are governed by the laws of Malaysia.</li>
    </ol>
</div>
</body>
</html>

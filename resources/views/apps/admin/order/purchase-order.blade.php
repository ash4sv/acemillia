<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order {{ $po_number }}</title>
    {{--<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">--}}
    <style>
        @page { margin: 0 }
        body { margin: 0 }
        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3               .sheet { width: 297mm; height: 419mm }
        body.A3.landscape     .sheet { width: 420mm; height: 296mm }
        body.A4               .sheet { width: 210mm; height: 296mm }
        body.A4.landscape     .sheet { width: 297mm; height: 209mm }
        body.A5               .sheet { width: 148mm; height: 209mm }
        body.A5.landscape     .sheet { width: 210mm; height: 147mm }
        body.letter           .sheet { width: 216mm; height: 279mm }
        body.letter.landscape .sheet { width: 280mm; height: 215mm }
        body.legal            .sheet { width: 216mm; height: 356mm }
        body.legal.landscape  .sheet { width: 357mm; height: 215mm }

        /** Padding area **/
        .sheet.padding-10mm { padding: 10mm }
        .sheet.padding-15mm { padding: 15mm }
        .sheet.padding-20mm { padding: 20mm }
        .sheet.padding-25mm { padding: 25mm }

        /** For screen preview **/
        @media screen {
            body { background: #e0e0e0 }
            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                margin: 5mm auto;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape { width: 420mm }
            body.A3, body.A4.landscape { width: 297mm }
            body.A4, body.A5.landscape { width: 210mm }
            body.A5                    { width: 148mm }
            body.letter, body.legal    { width: 216mm }
            body.letter.landscape      { width: 280mm }
            body.legal.landscape       { width: 357mm }
        }

        @page { size: A4 }
        body {
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; margin: 0;
            font-family: Arial, sans-serif; font-size: 9pt; line-height: 1.2;
        }
        .sheet { padding: 8mm; width: 210mm; }
        h1,h2,h3,p { margin: .25rem 0; }
        table { width:100%; border-collapse: collapse; }
        .table-receipt-content th,
        .table-receipt-content td {
            border:1px solid black; padding:.35rem .15rem;
            vertical-align: top;
        }
        .text-left  { text-align: left; }
        .text-right { text-align: right; }
        .text-center{ text-align: center; }
        .remove-border td, .remove-border th { border:none; }
        .item td:nth-child(2) { text-align: left; }
        .item td:nth-child(3),
        .item td:nth-child(4) { text-align: right; }
    </style>
</head>
<body class="A4">
<section class="sheet">
    <table>
        <tr><td colspan="6"><h2>Purchase Order</h2></td></tr>
        <tr>
            <td colspan="3">
                <img
                    src="https://www.ardianexus.com/assets/imgs/an-logo-light.png"
                    alt="Logo"
                    style="max-width:150px;"
                >
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="3">
                <p><strong>From:</strong></p>
                <p>Tekadex by Ardia Nexus Enterprise</p>
                <p>28-1, Jalan Sierra 10/3, Bandar 16 Sierra,</p>
                <p>47120 Puchong, Selangor, Malaysia</p>
                <p>www.tekad.my | info@tekad.com | +6017 670 5705</p>
            </td>
            <td colspan="3">
                <p><strong>To:</strong></p>
                <p>{{ $supplier->name }}</p>
                <p>{{ $supplier->address ?? '' }}</p>
                {{--<p>{{ $supplier->postcode ?? '' }} {{ $supplier->city ?? '' }}, {{ $supplier->state ?? '' }}</p>
                <p>{{ $supplier->country ?? '' }}</p>--}}
                <p>Tel: {{ $supplier->phone ?? '–' }}</p>
                <p>Email: {{ $supplier->email ?? '–' }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="3"><p><strong>PO Number:</strong> {{ $po_number }}</p></td>
            <td colspan="3"><p><strong>Date:</strong> {{ $date }}</p></td>
        </tr>
        <tr>
            <td colspan="6">
                <table class="table-receipt-content">
                    <thead>
                    <tr class="header">
                        <th colspan="2" class="text-left">Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        @php
                            $opts = json_decode($item->options, true) ?: [];
                        @endphp
                        <tr class="item">
                            <td colspan="2">
                                <p><strong>{{ $item->product->name ?? $item->product_name }}</strong></p>
                                @if(! empty($opts['selected_options']))
                                    <p>{{ collect($opts['selected_options'])
                                        ->map(fn($o)=> "{$o['name']}: {$o['value']}")
                                        ->implode(', ')
                                    }}</p>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">RM{{ number_format($item->price, 2) }}</td>
                            <td class="text-right">
                                RM{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="remove-border">
                        <td colspan="3"></td>
                        <td class="text-right"><strong>Sub-Total:</strong></td>
                        <td class="text-right">RM{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr class="remove-border">
                        <td colspan="3"></td>
                        <td class="text-right"><strong>Total:</strong></td>
                        <td class="text-right">RM{{ number_format($total, 2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <p><strong>Terms & Conditions</strong></p>
                <ol style="margin-top:0;">
                    <li>The quotation is valid for 23 days from the date above. After this period, Ardia Nexus Sdn Bhd may modify, revise, or refuse any.</li>
                    <li>All prices stated are in Malaysian Ringgit (MYR).</li>
                    <li>Once the client agrees, client should sign and return the quotation.</li>
                    <li>For any inquiries, please contact Muhamad Ashrafbin Abdullah at 017-571 3297.</li>
                    <li>Ardia Nexus Sdn Bhd may modify these terms without prior notice; changes will be communicated to the customer.</li>
                    <li>These terms shall be governed by the laws of Malaysia.</li>
                </ol>
            </td>
        </tr>
    </table>
</section>
</body>
</html>

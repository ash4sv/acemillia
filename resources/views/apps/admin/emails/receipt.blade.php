@component('mail::message')
# Thank you for your purchase, {{ $order->user->name }}

Your payment for order **#{{ $order->order_number }}** has been received.
Please find your receipt attached as a PDF.

{{--@component('mail::button', ['url' => url('/orders/'.$order->id)])
View your order
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

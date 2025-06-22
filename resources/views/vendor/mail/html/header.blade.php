@props(['url'])
<tr>
    <td class="header">
        {{--<a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                {{ $slot }}
            @endif
        </a>--}}
        <a href="{{ $url }}">
            <img src="{{ asset('assets/images/logo-neuraloka_black_admin.png') }}" alt="{{ config('app.name') }}" style="height: 50px;">
        </a>
    </td>
</tr>

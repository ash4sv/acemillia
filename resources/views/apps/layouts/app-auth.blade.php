<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-wide  customizer-hide"
      dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('apps').'/' }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title') ::   Event Management System</title>

    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('apps/img/favicon_io/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apps/img/favicon_io//apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('apps/img/favicon_io//favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('apps/img/favicon_io//favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('apps/img/favicon_io//site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

    @include(__('apps.layouts.__auth-css'))

    {{-- @turnstileScripts --}}

    @stack('style')

</head>
<body>

    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                @yield(__('auth_content'))

            </div>
        </div>
    </div>
    <!-- / Content -->

    @include(__('apps.layouts.__auth-js'))

    @include(__('sweetalert::alert'))

    @stack('script')

</body>
</html>

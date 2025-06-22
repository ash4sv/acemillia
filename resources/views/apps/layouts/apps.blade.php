<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('apps') . '/' }}" data-template="vertical-menu-template" data-style="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | ProdifyX</title>

    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('apps/img/favicon_io/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apps/img/favicon_io//apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('apps/img/favicon_io//favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('apps/img/favicon_io//favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('apps/img/favicon_io//site.webmanifest') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('apps/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('apps/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/summernote/dist/summernote-lite.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/fancyapps/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/seatLayout/seatLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/css/overwrite-style.css') }}">

    <!-- Page CSS -->
    @stack('style')
    <link rel="stylesheet" href="{{ asset('apps/vendor/css/pages/cards-advance.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('apps/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{--<script src="{{ asset('apps/vendor/js/template-customizer.js') }}"></script>--}}

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('apps/js/config.js') }}"></script>

</head>
<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            @include(__('apps.layouts.menu'))

            <!-- Layout container -->
            <div class="layout-page">
                @include(__('apps.layouts.navbar'))

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="flex-grow-1 container-p-y container-fluid">
                    @yield('content')
                    </div>

                    @include(__('apps.layouts.footer'))
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('apps/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('apps/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('apps/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('apps/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/summernote/dist/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/seatLayout/seatLayout.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/fancyapps/fancybox.umd.js') }}"></script>
    <script src="{{ asset('apps/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>

    <!-- Main JS -->
    <script src="{{ asset('apps/js/main.js') }}"></script>
    <script src="{{ asset('apps/js/apps-script.js') }}"></script>

    @include(__('sweetalert::alert'))
    {{--@include(__('apps.layouts.script'))--}}

    <!-- Page JS -->
    <script src="{{ asset('apps/js/dashboards-analytics.js') }}"></script>
    @stack('script')

    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FL2B81V05J"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-FL2B81V05J');
        </script>
    @endproduction

</body>
</html>

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
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/seatLayout/seatLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('apps/vendor/libs/fancyapps/fancybox.css') }}">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('apps/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('apps/css/style.css') }}" />
    @stack('css')

    <!-- Helpers -->
    <script src="{{ asset('apps/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{--<script src="{{ asset('apps/vendor/js/template-customizer.js') }}"></script>--}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('apps/js/config.js') }}"></script>

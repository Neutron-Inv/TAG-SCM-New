<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Enabled Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{$title . ' | '. config('app.name')}} </title>
    <meta name="description" content="SCM">
    <meta name="author" content="Enabled Solutions">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/fonts/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/bs-select/bs-select.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datatables/dataTables.bs4.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datatables/dataTables.bs4-custom.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/summernote/summernote-bs4.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datepicker/css/classic.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datepicker/css/classic.date.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/cards-advance.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>
 
<head>
<body class="" style="height:100vh;">
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <main style="min-height: 100vh;">
            @yield('content')
            </main>
        <footer class="main-footer" style="background:#28c76f !important;">&copy; {{ date('Y') }} Enabled Business Solutions. All Rights Reserved</footer>
        </div>
            </div>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/swiper/swiper.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/dashboards-analytics.js')}}"></script>
    <script src="{{asset('admin/assets/js/dashboards-ecommerce.js')}}"></script>
    <script src="{{asset('admin/assets/js/app-email.js')}}"></script>

    <script src="{{asset('admin/js/main.js')}}"></script>

</body>
</html>

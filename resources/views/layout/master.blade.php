<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $page_title ?? '') - @if(!empty($setting->app_name)){{ $setting->app_name }} @else {{ config('app.name') }} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('assets/img/'.$setting->favicon) }}" rel="icon">
    <link href="{{ url('assets/img/'.$setting->favicon) }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.gstatic.com" rel="preconnect"> --}}
    {!! Html::style('assets/css/css.css') !!}

    <!-- Vendor CSS Files -->
    {!! Html::style('assets/vendor/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendor/bootstrap-icons/bootstrap-icons.css') !!}
    {!! Html::style('assets/vendor/boxicons/css/boxicons.min.css') !!}
    {!! Html::style('assets/vendor/quill/quill.snow.css') !!}
    {!! Html::style('assets/vendor/quill/quill.bubble.css') !!}
    {!! Html::style('assets/vendor/remixicon/remixicon.css') !!}
    {!! Html::style('assets/vendor/simple-datatables/style.css') !!}
    {!! Html::style('assets/vendor/datatables/datatables.min.css') !!}

    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" /> --}}

    @stack('plugin-styles')

    <!-- Template Main CSS File -->
    {!! Html::style('assets/css/style.css') !!}

    @stack('style')

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <!-- ======= Header ======= -->
    @include('layout.header')

    <!-- ======= Sidebar ======= -->
    @if (auth()->user()->type == 'admin')
        @include('layout.sidebar')
    @else
        @include('layout.user_sidebar')
    @endif
    <main id="main" class="main">

        {{-- <div class="pagetitle">
            <h1>{{ $page_title }}</h1>
        </div><!-- End Page Title --> --}}


        @yield('content')


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    {{-- <footer id="footer" class="footer">
        @include('layout.footer')
    </footer><!-- End Footer --> --}}

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    {!! Html::script('assets/js/jquery-3.6.1.min.js') !!}
    {!! Html::script('assets/js/sweetalert.min.js') !!}
    {!! Html::script('assets/vendor/apexcharts/apexcharts.min.js') !!}
    {!! Html::script('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}
    {!! Html::script('assets/vendor/chart.js/chart.min.js') !!}
    {!! Html::script('assets/vendor/echarts/echarts.min.js') !!}
    {!! Html::script('assets/vendor/quill/quill.min.js') !!}
    {!! Html::script('assets/vendor/simple-datatables/simple-datatables.js') !!}
    {!! Html::script('assets/vendor/tinymce/tinymce.min.js') !!}
    {!! Html::script('assets/vendor/php-email-form/validate.js') !!}
    {!! Html::script('assets/vendor/datatables/datatables.min.js') !!}

    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script> --}}

    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- Template Main JS File -->
    {!! Html::script('assets/js/main.js') !!}

    @stack('custom-scripts')

</body>

</html>

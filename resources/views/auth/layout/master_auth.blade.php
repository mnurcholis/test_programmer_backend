<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $page_title ?? '') - @if(!empty($setting->app_name)){{ $setting->app_name }} @else {{ config('app.name') }} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('assets/img/'.$setting->favicon) }}" rel="icon">
    <link href="{{ url('assets/img/'.$setting->favicon) }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    {!! Html::style('assets/vendor/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendor/bootstrap-icons/bootstrap-icons.css') !!}
    {!! Html::style('assets/vendor/boxicons/css/boxicons.min.css') !!}
    {!! Html::style('assets/vendor/quill/quill.snow.css') !!}
    {!! Html::style('assets/vendor/quill/quill.bubble.css') !!}
    {!! Html::style('assets/vendor/remixicon/remixicon.css') !!}
    {!! Html::style('assets/vendor/simple-datatables/style.css') !!}

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

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ url('assets/img/'.$setting->logo) }}" alt="">
                                    <span class="d-none d-lg-block">{{ $setting->app_name }}</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    {!! Html::script('assets/vendor/apexcharts/apexcharts.min.js') !!}
    {!! Html::script('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}
    {!! Html::script('assets/vendor/chart.js/chart.min.js') !!}
    {!! Html::script('assets/vendor/echarts/echarts.min.js') !!}
    {!! Html::script('assets/vendor/quill/quill.min.js') !!}
    {!! Html::script('assets/vendor/simple-datatables/simple-datatables.js') !!}
    {!! Html::script('assets/vendor/tinymce/tinymce.min.js') !!}
    {!! Html::script('assets/vendor/php-email-form/validate.js') !!}

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- Template Main JS File -->
    {!! Html::script('assets/js/main.js') !!}

    @stack('custom-scripts')

</body>

</html>

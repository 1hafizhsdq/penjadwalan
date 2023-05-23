<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{asset('niceadmin')}}/assets/img/favicon.png" rel="icon">
    <link href="{{asset('niceadmin')}}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('niceadmin')}}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('niceadmin')}}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('niceadmin')}}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{asset('niceadmin')}}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{asset('niceadmin')}}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{asset('niceadmin')}}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    {{-- <link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    {{-- <link href="{{asset('niceadmin')}}/assets/vendor/simple-datatables/style.css" rel="stylesheet"> --}}
    <!-- datatable -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{asset('js/')}}/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('js/')}}/datatables/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('js/')}}/datatables/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Template Main CSS File -->
    <link href="{{asset('niceadmin')}}/assets/css/style.css" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('css')
</head>

<body>
    <!-- ======= Header ======= -->
    @include('layouts.partials.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('layouts.partials.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('layouts.partials.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('niceadmin')}}/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{asset('niceadmin')}}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('niceadmin')}}/assets/vendor/chart.js/chart.min.js"></script>
    <script src="{{asset('niceadmin')}}/assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{asset('niceadmin')}}/assets/vendor/quill/quill.min.js"></script>
    {{-- <script src="{{asset('niceadmin')}}/assets/vendor/simple-datatables/simple-datatables.js"></script> --}}
    <script src="{{asset('niceadmin')}}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{asset('niceadmin')}}/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('niceadmin')}}/assets/js/main.js"></script>

    <!-- jQuery -->
    <script src="{{asset('niceadmin/')}}/jquery.min.js"></script>
    <script src="{{asset('js/')}}/sweetalert.js"></script>
    
    <!-- DataTables  & Plugins -->
    <script src="{{asset('js/')}}/datatables/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    {{-- <script src="{{asset('js/')}}/datatables/jszip/jszip.min.js"></script>
    <script src="{{asset('js/')}}/datatables/pdfmake/pdfmake.min.js"></script>
    <script src="{{asset('js/')}}/datatables/pdfmake/vfs_fonts.js"></script> --}}
    <script src="{{asset('js/')}}/datatables/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{asset('js/')}}/datatables/datatables-buttons/js/buttons.colVis.min.js"></script>

    @stack('script')

</body>

</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Blog System</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/admin/css/')}}/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('assets/admin/images/')}}/favicon.png" />
  </head>
  <body>
    <div id="app">
        @if (Auth::check())
            <admin-main :permission="{{ Auth::user()->role->permission }}"></admin-main>
        @else
            <admin-main></admin-main>
        @endif

   </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{asset('assets/admin/vendors/js/')}}/vendor.bundle.base.js"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{asset('assets/admin/vendors/')}}/chart.js/Chart.min.js"></script>
    <script src="{{asset('assets/admin/vendors/')}}/moment/moment.min.js"></script>
    <script src="{{asset('assets/admin/vendors/')}}/daterangepicker/daterangepicker.js"></script>
    <script src="{{asset('assets/admin/vendors/')}}/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('assets/admin/js/')}}/off-canvas.js"></script>
    <script src="{{asset('assets/admin/js/')}}/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('assets/admin/js/')}}/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
   <!-- plugins:css -->
   <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/simple-line-icons/css/simple-line-icons.css">
   <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/flag-icon-css/css/flag-icon.min.css">
   <link rel="stylesheet" href="{{asset('assets/admin/vendors/')}}/css/vendor.bundle.base.css">

   <link rel="stylesheet" href="{{asset('assets/admin/css/')}}/style.css">
   <!-- End layout styles -->
   <link rel="shortcut icon" href="{{asset('assets/admin/images/')}}/favicon.png" />
  </head>
  <body>

    <div id="loginApp">
        <login-app></login-app>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('js/login_app.js') }}" defer></script>
    <script src="{{asset('assets/admin/vendors/js/')}}/vendor.bundle.base.js"></script>
     <!-- inject:js -->
     <script src="{{asset('assets/admin/js/')}}/off-canvas.js"></script>
     <script src="{{asset('assets/admin/js/')}}/misc.js"></script>
    <!-- endinject -->
  </body>
</html>

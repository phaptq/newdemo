<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <title></title>
    <!--  -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="{{asset('themes/client/css/bootstrap.min.css')}}">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="{{asset('themes/client/css/plugins.css')}}">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="{{asset('themes/client/css/main.css')}}">

    <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <link rel="stylesheet" href="{{asset('themes/client/css/themes.css')}}">

    <!-- END Stylesheets -->

    <!-- Modernizr (browser feature detection library) & Respond.js (enables responsive CSS code on browsers that don't support it, eg IE8) -->
    <script src="{{asset('themes/client/js/vendor/modernizr-respond.min.js')}}"></script>
    <script src="{{asset('themes/client/js/vendor/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('themes/client/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('themes/client/js/highcharts.js')}}"></script>
    <!-- <script src="{{asset('themes/client/js/exporting.js')}}"></script> -->
<body>
    <!-- Page Container -->
    <!-- In the PHP version you can set the following options from inc/config file -->
    <!-- 'boxed' class for a boxed layout -->
    <div id="page-container">
        <!-- Site Header -->
        @include('client.layouts.header')
        <!-- END Site Header -->

        <!-- Start Site Content -->
        @section('content')
        @show

        <!-- Footer -->
        @include('client.layouts.footer')
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->
    <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
    <a href="#" id="to-top"><i class="fa fa-angle-up"></i></a>
    <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
    <script src="{{asset('themes/client/js/plugins.js')}}"></script>
    <script src="{{asset('themes/client/js/app.js')}}"></script>
    @include('client.modal.contact')
    <!-- Modal Terms -->
    @include('client.modal.privacy')
    <!-- END Modal Terms -->
</body>
</html>
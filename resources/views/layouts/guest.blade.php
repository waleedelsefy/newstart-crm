<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <x-layouts.head />

    @if (config('app.locale') == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors-rtl.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css-rtl/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css-rtl/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css-rtl/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css-rtl/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css-rtl/pages/authentication.min.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/authentication.min.css') }}">
    @endif
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body
    class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('js/core/app-menu.js') }}"></script>
    <script src="{{ asset('js/core/app.js') }}"></script>

</body>
<!-- END: Body-->

</html>

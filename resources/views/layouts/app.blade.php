<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <x-layouts.head />

    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <x-layouts.styles-rtl />
    @else
        <x-layouts.styles />
    @endif

    <link rel="stylesheet" href="{{ asset('css/general.css') }}?v=1">

    @stack('styles')
    @yield('styles')


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <x-layouts.header />
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <x-main-menu />
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <!-- BEGIN: Breadcrumb-->
            @if ($breadcrumb ?? true)
                <x-layouts.breadcrumbs />
            @endif
            <!-- END: Breadcrumb-->

            <div class="content-body">
                @yield('content')


                {{-- @can('use-floating-box')
                    <div class="floating-box">

                        <div class="floating-box-toggle">
                            <x-buttons.dark text="" icon="feather icon-archive" />
                        </div>

                        <div class="floating-box-content" style="display: none">

                            @can('create', \App\Models\Lead::class)
                                <div class="floating-box-item">
                                    <x-buttons.primary href="{{ route('leads.create') }}" text="" icon="fa fa-plus" />
                                </div>
                            @endcan

                            @can('view-any-lead')
                                @if (Route::is('leads.index'))
                                    <div class="floating-box-item">
                                        <!-- Button trigger modal -->
                                        <x-buttons.warning text="" icon="fa fa-filter" type="button"
                                            class="leads-filter-modal-button" data-toggle="modal"
                                            data-target="#leads-top-filters-model" />
                                    </div>
                                @else
                                    <div class="floating-box-item">
                                        <div class="floating-box-item">
                                            <x-buttons.success href="{{ route('leads.index') }}" text=""
                                                icon="feather icon-users" />
                                        </div>
                                    </div>
                                @endif
                            @endcan

                        </div>
                    </div>
                @endcan --}}

                @can('create', \App\Models\Lead::class)
                    <div class="floating-box-item">
                        <x-buttons.primary href="{{ route('leads.create') }}" text="" icon="fa fa-plus"
                            class="btn-floating z-index-1" />
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <div id="modal-area"></div>


    <!-- BEGIN: Footer-->
    <x-layouts.footer />
    <!-- END: Footer-->


    <!-- BEGIN: Page JS-->

    <x-layouts.scripts />

    @stack('scripts')
    @yield('scripts')

    <!-- END: Page JS-->


    <script>
        $(".floating-box-toggle").on('click', function() {
            $(".floating-box-content").toggle();
        })
    </script>


</body>
<!-- END: Body-->

</html>

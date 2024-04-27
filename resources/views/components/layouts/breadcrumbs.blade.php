<div class="content-header row">


    <div class="content-header-left col-md-9 col-12 mb-2">

        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">@yield('title', config('app.name'))</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        @section('breadcrumb')
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
                            </li>
                        @show
                    </ol>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrum-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="feather icon-settings"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Chat</a>
                    <a class="dropdown-item" href="#">Email</a>
                    <a class="dropdown-item" href="#">Calendar</a>
                </div>
            </div>
        </div>
    </div> --}}

</div>

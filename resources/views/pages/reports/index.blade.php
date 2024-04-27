@extends('layouts.app')

@section('title', __('Reports'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="row">

        @can('view-sales-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.sales.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-info font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Sales') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-marketing-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.marketing.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-success font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Marketing') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan


        @can('view-assign-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.assign.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-dark p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-dark font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Assign Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-created-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.created.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-danger font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Created Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-my-reports-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.my-reports.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('My Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-sources-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.sources.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-info font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Sources Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-projects-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.projects.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-info font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Projects Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('view-interests-reports')
            <div class="col-lg-6">
                <a href="{{ route('reports.interests.index') }}" class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="feather icon-bar-chart-2 text-info font-medium-5"></i>
                                </div>
                            </div>
                            <p class="mb-0 line-ellipsis">{{ __('Interests Reports') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

    </div>
@endsection

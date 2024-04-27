@extends('layouts.app')

@section('title', __('Comparison'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        <a href="{{ route('reports.index') }}">{{ __('Reports') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <form action="">
        <div class="row">

            <div class="col-lg-6">
                <div class="scrollable-leads-filter mb-1">
                    <div class="scrollable-wrapper">
                        <div class="scrollable-slide">
                            <div class="form-group">
                                <label for="from_date_left">{{ __('From Date') }}</label>
                                <input type="date" name="from_date_left" id="from_date_left" class="form-control"
                                    value="{{ request()->get('from_date_left') }}">
                            </div>
                        </div>

                        <div class="scrollable-slide">
                            <div class="form-group">
                                <label for="to_date_left">{{ __('To Date') }}</label>
                                <input type="date" name="to_date_left" id="to_date_left" class="form-control"
                                    value="{{ request()->get('to_date_left') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <x-charts.bar title="" prefix="comparison_left" id="comparison_left-chart" :data="$comparison_left"
                    label="" />
            </div>

            <div class="col-lg-6">
                <div class="scrollable-leads-filter mb-1">
                    <div class="scrollable-wrapper">
                        <div class="scrollable-slide">
                            <div class="form-group">
                                <label for="from_date_right">{{ __('From Date') }}</label>
                                <input type="date" name="from_date_right" id="from_date_right" class="form-control"
                                    value="{{ request()->get('from_date_right') }}">
                            </div>
                        </div>

                        <div class="scrollable-slide">
                            <div class="form-group">
                                <label for="to_date_right">{{ __('To Date') }}</label>
                                <input type="date" name="to_date_right" id="to_date_right" class="form-control"
                                    value="{{ request()->get('to_date_right') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <x-charts.bar title="" prefix="comparison_right" id="comparison_right-chart" :data="$comparison_right"
                    label="" />
            </div>

        </div>

        <x-buttons.primary text="{{ __('Start Compare') }}" icon="feather icon-search" />

        <x-buttons.light href="{{ route('comparison.index', $type) }}" text="{{ __('Reset') }}"
            icon="feather icon-loader" />
    </form>


@endsection

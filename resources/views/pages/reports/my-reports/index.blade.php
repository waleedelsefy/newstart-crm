@extends('layouts.app')

@section('title', __('My Reports'))

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
    <div class="row">

        <div class="col-12 mb-2">
            @include('pages.reports.partials._form-filter', ['without_search' => true])
        </div>

        <div class="col-md-6">
            <x-charts.bar title="{{ __('Leads Count Of Each Branch') }}" comparison="leads" prefix="leadsOfEachBranch"
                id="leads-of-each-branch-chart" :data="$leadsOfEachBranch" label="{{ __('Leads') }}" />
        </div>

        <div class="col-md-6">
            <x-charts.bar title="{{ __('Events Count') }}" comparison="events" prefix="eventsCount" id="events-count-chart"
                :data="$eventsCount" label="{{ __('Events') }}" />
        </div>
    </div>
@endsection

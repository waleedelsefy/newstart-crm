@extends('layouts.app')

@php
    $breadcrumb = false;
@endphp

@section('title', 'Dashboard')

@push('styles')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/tether.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/tour/tour.css') }}">
    <!-- END: Page CSS-->

    <style>
        .filter-by-team-or-me {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;


        }

        .filter-by-team-or-me-item {}

        .filter-by-team-or-me input {
            display: none;
        }

        .filter-by-team-or-me label {
            background-color: #f1f1f1;
            border: 1px solid #e0e0e0;
            font-size: 14px;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
        }

        .filter-by-team-or-me input[type=radio]:checked+label {
            background-color: #7367f0;
            color: #fff;
        }
    </style>
@endpush



@section('content')


    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row">

            <div class="col-12">
                <div class="card bg-analytics text-white">
                    <div class="card-content">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/elements/decore-left.png') }}" class="img-left" alt="card-img-left">
                            <img src="{{ asset('images/elements/decore-right.png') }}" class="img-right"
                                alt="card-img-right">
                            <div class="avatar avatar-xl bg-primary shadow mt-0">
                                <div class="avatar-content">
                                    <i class="feather icon-award white font-large-1"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h1 class="mb-2 text-white"> {{ __('Welcome') }} {{ auth()->user()->name }}</h1>
                                {{-- <p class="m-auto w-75">You have done <strong>57.6%</strong> more sales today. Check your new
                                    badge in your profile.</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-filter card">
            <div class="card-body">
                <form action="">

                    <div class="scrollable-leads-filter mb-1">
                        <div class="scrollable-wrapper">
                            @if (auth()->user()->owner == 0 && auth()->user()->hasRole('marketing-team-leader', 'marketing-manager'))
                                <div class="scrollable-slide" style="width: fit-content">
                                    <div class="filter-by-team-or-me">
                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="created_by" id="filter-by-team-or-me-1"
                                                value="me" @checked(request()->get('created_by') == 'me')>
                                            <label for="filter-by-team-or-me-1">{{ __('Me') }}</label>
                                        </div>

                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="created_by" id="filter-by-team-or-me-2"
                                                value="my_team" @checked(request()->get('created_by') == 'my_team')>
                                            <label for="filter-by-team-or-me-2">{{ __('My Team') }}</label>
                                        </div>

                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="created_by" id="filter-by-team-or-me-3"
                                                value="me_my_team" @checked(request()->get('created_by') == 'me_my_team' || is_null(request()->get('created_by')))>
                                            <label for="filter-by-team-or-me-3">{{ __('Me & My Team') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="scrollable-slide">
                                    <x-form.select :select2="true" name="creators_ids[]" multiple
                                        label="{{ __('Created By') }}">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach ($creators as $creator)
                                            <option value="{{ $creator->id }}" @selected(in_array($creator->id, request()->get('creators_ids') ?? []))>
                                                {{ $creator->username }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            @elseif (auth()->user()->owner == 0 && auth()->user()->hasRole('sales-team-leader', 'sales-manager'))
                                <div class="scrollable-slide">
                                    <div class="filter-by-team-or-me">
                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="assigned_to" id="filter-by-team-or-me-1"
                                                value="me" @checked(request()->get('assigned_to') == 'me')>
                                            <label for="filter-by-team-or-me-1">{{ __('Me') }}</label>
                                        </div>

                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="assigned_to" id="filter-by-team-or-me-2"
                                                value="my_team" @checked(request()->get('assigned_to') == 'my_team')>
                                            <label for="filter-by-team-or-me-2">{{ __('My Team') }}</label>
                                        </div>

                                        <div class="filter-by-team-or-me-item">
                                            <input type="radio" name="assigned_to" id="filter-by-team-or-me-3"
                                                value="me_my_team" @checked(request()->get('assigned_to') == 'me_my_team' || is_null(request()->get('assigned_to')))>
                                            <label for="filter-by-team-or-me-3">{{ __('Me & My Team') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="scrollable-slide">
                                    <x-form.select :select2="true" name="assigned_to_users[]" multiple
                                        label="{{ __('Assign To Users') }}">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach ($usersAvailableToAssign as $user)
                                            <option value="{{ $user->id }}" @selected(in_array($user->id, request()->get('assigned_to_users') ?? []))>
                                                {{ $user->username }} - [ {{ $user->jobTitle() }} ]
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            @else
                                <div class="scrollable-slide">
                                    <x-form.select :select2="true" name="assigned_to_users[]" multiple
                                        label="{{ __('Assign To Users') }}">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach ($usersAvailableToAssign as $user)
                                            <option value="{{ $user->id }}" @selected(in_array($user->id, request()->get('assigned_to_users') ?? []))>
                                                {{ $user->username }} - [ {{ $user->jobTitle() }} ]
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>

                                <div class="scrollable-slide">
                                    <x-form.select :select2="true" name="creators_ids[]" multiple
                                        label="{{ __('Created By') }}">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach ($creators as $creator)
                                            <option value="{{ $creator->id }}" @selected(in_array($creator->id, request()->get('creators_ids') ?? []))>
                                                {{ $creator->username }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            @endif

                            <div class="scrollable-slide">
                                <div class="form-group">
                                    <label for="from_date">{{ __('From Date') }}</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ request()->get('from_date') }}">
                                </div>
                            </div>

                            <div class="scrollable-slide">
                                <div class="form-group">
                                    <label for="from_time">{{ __('From Time') }}</label>
                                    <input type="time" name="from_time" id="from_time" class="form-control"
                                        value="{{ request()->get('from_time') }}">
                                </div>
                            </div>

                            <div class="scrollable-slide">
                                <div class="form-group">
                                    <label for="to_date">{{ __('To Date') }}</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ request()->get('to_date') }}">
                                </div>
                            </div>

                            <div class="scrollable-slide">
                                <div class="form-group">
                                    <label for="to_time">{{ __('To Time') }}</label>
                                    <input type="time" name="to_time" id="to_time" class="form-control"
                                        value="{{ request()->get('to_time') }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-buttons.primary text="{{ __('Search') }}" icon="feather icon-search" />
                    <x-buttons.light href="{{ route('dashboard.index') }}" text="{{ __('Reset') }}"
                        icon="feather icon-loader" />
                </form>
            </div>
        </div>


        @can('employees-dashboard')
            <div class="divider">
                <div class="divider-text">{{ __('Employees') }}</div>
            </div>

            <div class="row">

                {{-- Employees --}}

                @can('view-employees-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index') }}">{{ $employeesCount }}</a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Employees') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-owners-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 'owner']) }}">{{ $ownersCount }}</a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Owners') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-admins-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 1]) }}">
                                            {{ $adminsCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Admins') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-marketing-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 2]) }}">
                                            {{ $marketingCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Marketing') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-sales-managers-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 3]) }}">
                                            {{ $salesManagersCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Sales Managers') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-team-leaders-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 4]) }}">
                                            {{ $teamLeadersCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Team Leaders') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                {{-- @can('view-sales-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">{{ $salesCount }}</h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Sales') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan --}}

                @can('view-senior-sales-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 6]) }}">
                                            {{ $seniorSalesCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Senior Sales') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-junior-sales-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('users.index', ['role_id' => 5]) }}">
                                            {{ $juniorSalesCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Junior Sales') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        @endcan

        @can('leads-dashboard')
            <div class="divider">
                <div class="divider-text">{{ __('Leads') }}</div>
            </div>

            <div class="row">
                {{-- Leads --}}

                @can('view-leads-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $leadsCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Leads') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-leads-assigned-by-you-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('leads.index', ['assigned_by_users[0]' => auth()->id()]) }}">
                                            {{ $leadsAssignedByYou }}
                                        </a>

                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Assigned by you') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-teams-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-layers text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('teams.index') }}">
                                            {{ $teamsCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Teams') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-teams-i-lead-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-layers text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('teams.index', ['team_role' => 'leader']) }}">
                                            {{ $teamsILeadCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Teams I Lead') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-teams-i-member-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-layers text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('teams.index', ['team_role' => 'member']) }}">
                                            {{ $teamsIMemberCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Teams I Member') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        @endcan

        @can('events-dashboard')
            <div class="divider">
                <div class="divider-text">{{ __('Events') }}</div>
            </div>

            <div class="row">

                @can('view-event-no-action-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'events_ids[0]' => 'no-action',
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $noActionCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('no-action') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-event-today-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'reminder' => 'today',
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $leadsTodayCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Today') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-event-upcoming-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'reminder' => 'upcoming',
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $leadsUpcomingCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Upcoming') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-event-delay-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'reminder' => 'delay',
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $leadsDelayCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Delay') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan


                @foreach ($eventsCount as $eventCount)
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a
                                            href="{{ route('leads.index', [
                                                'events_ids[0]' => $eventCount->event,
                                                'creators_ids' => request()->get('creators_ids'),
                                                'assigned_to_users' => request()->get('assigned_to_users'),
                                                'assigned_to' => request()->get('assigned_to'),
                                                'from_date' => request()->get('from_date'),
                                                'to_date' => request()->get('to_date'),
                                            ]) }}">
                                            {{ $eventCount->count }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __($eventCount->event) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        @endcan


        @can('system-dashboard')
            <div class="divider">
                <div class="divider-text">{{ __('System') }}</div>
            </div>

            <div class="row">

                @can('view-branches-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-database text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('branches.index') }}">
                                            {{ $systemBranchesCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Branches') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-projects-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-dark p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-map text-dark font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('projects.index') }}">
                                            {{ $systemProjectsCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Projects') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-developers-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-warning font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('developers.index') }}">
                                            {{ $systemDevelopersCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Developers') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-interests-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-heart text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('interests.index') }}">
                                            {{ $systemInterestsCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Interests') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-sources-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-light p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-search text-light font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('sources.index') }}">
                                            {{ $systemSourcesCount }}
                                        </a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Sources') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('view-events-count-dashboard')
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-activity text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">
                                        <a href="{{ route('events.index') }}">{{ $systemEventsCount }}</a>
                                    </h2>
                                    <p class="mb-0 line-ellipsis">{{ __('Events') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        @endcan


    </section>
    <!-- Dashboard Analytics end -->

@endsection


@push('scripts')
    <script src="{{ asset('js/scripts/components.js') }}"></script>

    <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
@endpush

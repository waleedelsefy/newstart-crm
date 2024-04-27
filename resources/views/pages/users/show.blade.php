@extends('layouts.app')

@section('title', 'User Details')

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('users.index') }}">{{ __('Users List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <section class="page-users-view">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Account') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="users-view-image">
                                <img src="{{ $user->getPhoto() }}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1"
                                    alt="avatar">
                            </div>
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Username') }}</td>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Name') }}</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Email') }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Created By') }}</td>
                                            <td>
                                                {{ $user->createdBy->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Created At') }}</td>
                                            <td>{{ $user->createdAt() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Status') }}</td>
                                            <td>
                                                @if ($user->active)
                                                    <x-badges.success text="{{ __('Active') }}" />
                                                @else
                                                    <x-badges.danger text="{{ __('Deactive') }}" />
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Assignable') }}</td>
                                            <td>
                                                @if ($user->assignable)
                                                    <x-badges.success text="{{ __('Assignable') }}" />
                                                @else
                                                    <x-badges.danger text="{{ __('Unassignable') }}" />
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Role') }}</td>
                                            <td>
                                                <x-badges.primary text="{{ $user->jobTitle() }}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Branch') }}</td>
                                            <td>{{ $user->branch->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('Last Seen At') }}</td>
                                            <td>{{ $user->lastSeenDate() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

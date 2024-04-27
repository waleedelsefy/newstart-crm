@extends('layouts.app')

@section('title', __('Notifications'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')
    <x-badges.primary class="mb-2" icon="feather icon-bell" text="{{ auth()->user()->notifications->count() }}" />

    @if (auth()->user()->unreadNotifications->count())
        <x-badges.success class="mb-2" icon="feather icon-eye-off" text="{{ auth()->user()->unreadNotifications->count() }}"
            fullDescripition="{{ true }}" />

        <x-buttons.primary text="{{ __('Read All') }}" href="{{ route('notifications.markAllAsRead') }}" class="btn-sm" />
    @endif

    <ul class="card list-unstyled">
        <x-layouts.notifications-content :notifications="$notifications" :fullDescription="true" />
    </ul>

    <div class="app-pagination">
        {{ $notifications->links() }}
    </div>
@endsection

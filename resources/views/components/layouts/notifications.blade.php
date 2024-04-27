@props(['notifications'])



<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
        <i class="ficon feather icon-bell"></i>
        @if ($notifications->count())
            <span class="badge badge-pill badge-primary badge-up">{{ $notifications->count() }}</span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <div class="dropdown-header m-0 p-2">
                <h3 class="white">
                    {{ $notifications->count() }} {{ __('New') }}
                </h3>
                <span class="grey darken-2">{{ __('App Notifications') }}</span>
            </div>
        </li>

        <x-layouts.notifications-content :notifications="$notifications->take(5)" />


        <li class="dropdown-menu-footer">
            <a class="dropdown-item p-1 text-center" href="{{ route('notifications.index') }}">
                {{ __('Read all notifications') }}
            </a>
        </li>

    </ul>
</li>

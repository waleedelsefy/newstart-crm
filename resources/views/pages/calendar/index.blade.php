@extends('layouts.app')

@section('title', __('Calendar'))

@push('styles')
    <style>
        td {
            width: 100px;
            height: 120px;
        }
    </style>
@endpush

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <form action="">

        <div class="scrollable-leads-filter">
            <div class="scrollable-wrapper">
                @can('lead-created-at-filter')
                    <div class="scrollable-slide">
                        <div class="form-group">
                            <label for="reminder_date">{{ __('From Date') }}</label>
                            <input type="date" name="reminder_date" id="reminder_date" class="form-control"
                                value="{{ request()->get('reminder_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                @endcan

                @can('lead-reminder-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="reminder" label="{{ __('Reminder') }}">
                            <option value="">{{ __('All') }}</option>

                            <option value="upcoming" @selected(request()->get('reminder') == 'upcoming')>
                                {{ __('Upcoming') }}
                            </option>

                            <option value="today" @selected(request()->get('reminder') == 'today')>
                                {{ __('Today') }}
                            </option>
                        </x-form.select>
                    </div>
                @endcan

            </div>

        </div>


        <div style="margin-top: 4px;gap:5px" class="d-flex align-items-center">

            <x-buttons.primary text="{{ __('Search') }}" icon="feather icon-search" />

            <x-buttons.light href="{{ route('calendar.index') }}" text="{{ __('Reset') }}" icon="feather icon-loader" />

        </div>

    </form>

    <div class="card mt-1">
        <div class="card-body">

            <div class="text-center">
                @foreach ($remindersBadges as $reminderBadge)
                    @if ($reminderBadge->reminder == 'today')
                        <x-badges.success text="{{ strtoupper($reminderBadge->reminder) . ' | ' . $reminderBadge->count }}"
                            style="font-size:16px" />
                    @elseif($reminderBadge->reminder == 'upcoming')
                        <x-badges.primary text="{{ strtoupper($reminderBadge->reminder) . ' | ' . $reminderBadge->count }}"
                            style="font-size:16px" />
                    @endif
                @endforeach
            </div>


            <div class="table-responsive mt-1">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Lead') }}</th>
                            <th scope="col">{{ __('Notes') }}</th>
                            <th scope="col">{{ __('Reminder') }}</th>
                            <th scope="col">{{ __('Reminder Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($leads as $lead)
                            <tr>
                                <td>
                                    <a href="{{ route('leads.show', $lead->id) }}">{{ $lead->name }}</a>
                                </td>
                                <td>{{ $lead->notes }}</td>
                                <td>

                                    @if ($lead->reminder == 'today')
                                        <x-badges.success text="{{ strtoupper($lead->reminder) }}" />
                                    @elseif($lead->reminder == 'upcoming')
                                        <x-badges.primary text="{{ strtoupper($lead->reminder) }}" />
                                    @endif

                                </td>
                                <td>{{ Carbon\Carbon::parse($lead->reminder_date)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="bottom-actions mt-2">
        <div class="app-pagination">
            {{ $leads->links() }}
        </div>
    </div>
@endsection

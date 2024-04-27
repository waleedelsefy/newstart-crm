@extends('layouts.app')

@section('title', __('Show Lead'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('leads.index') }}">{{ __('Leads List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection

@push('styles')
    <style>
        .lead-list {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            list-style: none;
            gap: 15px;
            padding: 0;
            margin: 0;
        }

        .lead-list-item {}

        .history-user-photo {
            max-width: 50px;
            max-height: 50px;
            border-radius: 50%;
        }

        .history-notes {
            background-color: #f8f8f8;
            padding: 10px;
            margin-top: 8px;
            display: block;
            border-radius: 6px;
            font-size: 13px;
        }

        .history-created-at {
            font-weight: bold;
            font-size: 10px
        }
    </style>
@endpush


@section('content')

    <div class="card">
        <div class="card-body">
            @can('view-lead-name')
                <x-headings.h2 class="mb-2">
                    <b>
                        {{ $lead->name }}
                    </b>
                </x-headings.h2>
            @endcan

            <div class="divider">
                <div class="divider-text">{{ __('Main Information') }}</div>
            </div>

            @can('view-lead-notes')
                <div class="card border">
                    <div class="card-body">
                        @if ($lead->notes)
                            <div>
                                {!! $lead->notes !!}
                            </div>
                        @else
                            <p>{{ __('Nothing') }}</p>
                        @endif
                    </div>
                </div>
            @endcan

            <div class="row">
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @can('view-lead-created-by')
                                        <th>{{ __('Created By') }}</th>
                                    @endcan

                                    @can('view-lead-created-at')
                                        <th>{{ __('Created At') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    @can('view-lead-created-by')
                                        <td>
                                            @if ($lead->createdBy)
                                                <a href="{{ route('users.show', $lead->createdBy) }}" class="chip">
                                                    <div class="chip-body">
                                                        <div class="avatar">
                                                            <img class="img-fluid" src="{{ $lead->createdBy->getPhoto() }}"
                                                                alt="{{ $lead->createdBy->username }}">
                                                        </div>
                                                        <span class="chip-text">{{ $lead->createdBy->username }}</span>
                                                    </div>
                                                </a>
                                            @else
                                                <x-badges.light text="{{ __('No One') }}" />
                                            @endif
                                        </td>
                                    @endcan

                                    @can('view-lead-created-at')
                                        <td>
                                            {{ $lead->created_at }}
                                        </td>
                                    @endcan
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @can('view-lead-assigned-by')
                                        <th>{{ __('Assigned By') }}</th>
                                        <th>{{ __('Assigned At') }}</th>
                                    @endcan

                                    @can('view-lead-assigned-to')
                                        <th>{{ __('Assigned To') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    @can('view-lead-assigned-by')
                                        <td>
                                            @if ($lead->assignedBy)
                                                <a href="{{ route('users.show', $lead->assignedBy) }}" class="chip">
                                                    <div class="chip-body">
                                                        <div class="avatar">
                                                            <img class="img-fluid" src="{{ $lead->assignedBy->getPhoto() }}"
                                                                alt="{{ $lead->assignedBy->username }}">
                                                        </div>
                                                        <span class="chip-text">{{ $lead->assignedBy->username }}</span>
                                                    </div>
                                                </a>
                                            @else
                                                <x-badges.light text="{{ __('No One') }}" />
                                            @endif
                                        </td>


                                        <td>
                                            {{ $lead->assigned_at }}
                                        </td>
                                    @endcan

                                    @can('view-lead-assigned-to')
                                        <td>
                                            @if ($lead->assignedTo)
                                                <a href="{{ route('users.show', $lead->assignedTo) }}" class="chip">
                                                    <div class="chip-body">
                                                        <div class="avatar">
                                                            <img class="img-fluid" src="{{ $lead->assignedTo->getPhoto() }}"
                                                                alt="{{ $lead->assignedTo->username }}">
                                                        </div>
                                                        <span class="chip-text">{{ $lead->assignedTo->username }}</span>
                                                    </div>
                                                </a>
                                            @else
                                                <x-badges.light text="{{ __('No One') }}" />
                                            @endif
                                        </td>
                                    @endcan
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                @can('view-lead-phones')
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Phones List') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lead->phones as $phone)
                                        <tr>
                                            <td style="direction: ltr">{{ $phone->number }}</td>
                                            <td>
                                                <x-buttons.success
                                                    href="https://api.whatsapp.com/send?phone={{ $phone->phoneWithoutPlus() }}"
                                                    text="" icon="fa fa-whatsapp" class="btn-sm" target="blank" />

                                                <x-buttons.primary href="tel:{{ $phone->number }}" text=""
                                                    icon="fa fa-phone" class="btn-sm" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">{{ __('Unknown') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan

                @can('view-lead-interests')
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Interests List') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lead->interests as $interest)
                                        <tr>
                                            <td>{{ $interest->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{ __('Unknown') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan

                @can('view-lead-sources')
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Sources List') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lead->sources as $source)
                                        <tr>
                                            <td>{{ $source->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{ __('Unknown') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan

                @can('view-lead-projects')
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Project') }}</th>
                                        <th>{{ __('Developer') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lead->projects as $project)
                                        <tr>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->developer->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{ __('Unknown') }}</td>
                                            <td>{{ __('Unknown') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan

            </div>

            @can('view-lead-event')
                <div class="divider">
                    <div class="divider-text">{{ __('Last Event') }}</div>
                </div>

                <div class="row">

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Event') }}</th>
                                        <th>{{ __('Reminder') }}</th>
                                        <th>{{ __('Created By') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Follow-Up Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                            @if ($lead->event == 'fresh')
                                                <x-badges.light text="{{ $lead->event }}" />
                                            @else
                                                <x-badges.info text="{{ $lead->event }}" />
                                            @endif

                                            @can('changeLeadEvent', $lead)
                                                <x-buttons.primary href="{{ route('leads.event', ['lead' => $lead]) }}"
                                                    text="" icon="fa fa-edit" class="add-event btn-xs" />
                                            @endcan
                                        </td>

                                        <td>
                                            @if ($lead->reminder == 'today')
                                                <x-badges.success text="{{ strtoupper($lead->reminder) }}" />
                                            @elseif($lead->reminder == 'upcoming')
                                                <x-badges.primary text="{{ strtoupper($lead->reminder) }}" />
                                            @elseif($lead->reminder == 'delay')
                                                <x-badges.danger text="{{ strtoupper($lead->reminder) }}" />
                                            @else
                                                <x-badges.light text="{{ __('Nothing') }}" />
                                            @endif
                                        </td>

                                        <td>
                                            @if ($lead->eventCreatedBy)
                                                <a href="{{ route('users.show', $lead->eventCreatedBy) }}" class="chip">
                                                    <div class="chip-body">
                                                        <div class="avatar">
                                                            <img class="img-fluid"
                                                                src="{{ $lead->eventCreatedBy->getPhoto() }}"
                                                                alt="{{ $lead->eventCreatedBy->username }}">
                                                        </div>
                                                        <span class="chip-text">{{ $lead->eventCreatedBy->username }}</span>
                                                    </div>
                                                </a>
                                            @else
                                                <x-badges.light text="{{ __('No One') }}" />
                                            @endif
                                        </td>

                                        <td>
                                            {{ $lead->event_created_at ? $lead->event_created_at : __('Unknown') }}
                                        </td>

                                        <td>
                                            {{ $lead->reminder_date ? $lead->reminder_date : __('Unknown') }}
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="col-12">

                        @php
                            $notes = $lead->histories->where('type', 'event')->first()->notes ?? '';
                        @endphp

                        @if ($notes)
                            <div class="history-notes">
                                {!! $notes !!}
                            </div>
                        @else
                            <p class="history-notes">{{ __('Nothing') }}</p>
                        @endif

                        {{-- @if ($lead->lastEvent()->notes)
                            <div class="history-notes">
                                {!! $lead->lastEvent()->notes !!}
                            </div>
                        @else
                            <p class="history-notes">{{ __('Nothing') }}</p>
                        @endif --}}
                    </div>
                </div>
            @endcan

        </div>
    </div>

    @can('view-lead-history-list')
        <div class="card lead-history">
            <div class="card-body">
                <x-headings.h2 class="mb-3">
                    {{ __('Lead History') }}
                </x-headings.h2>

                <ul class="history-list m-0">
                    @foreach ($histories as $history)
                        <li class="mb-2 d-flex flex-wrap" style="gap: 10px">
                            @if ($history->user)
                                <img class="history-user-photo" src="{{ $history->user->getPhoto() }}"
                                    alt="{{ $history->user->username }}">
                            @endif

                            <div>
                                <span class="d-block m-0">{!! $history->info !!}</span>

                                @if ($history->notes)
                                    <span class="history-notes">
                                        {!! $history->notes !!}
                                    </span>
                                @else
                                    <span class="history-notes">{{ __('Nothing') }}</span>
                                @endif
                                <small class="history-created-at">
                                    {{ $history->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div>
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    @endcan


@endsection

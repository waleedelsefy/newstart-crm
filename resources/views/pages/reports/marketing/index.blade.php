@extends('layouts.app')

@section('title', __('Marketing'))

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
            @include('pages.reports.partials._form-filter')
        </div>

        @foreach ($users as $user)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mx-auto">
                        <div class="avatar avatar-xl">
                            <a href="{{ route('users.show', $user) }}">
                                <img class="img-fluid" src="{{ $user->getPhoto() }}" alt="img placeholder">
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body text-center">
                            <a href="{{ route('users.show', $user) }}">
                                <h4>{{ $user->name }}</h4>
                            </a>
                            <p class="">{{ $user->jobTitle() }}</p>


                            <div class="d-flex justify-content-between mt-2">
                                <div class="uploads">
                                    <a
                                        href="{{ route('leads.index', [
                                            'creators_ids[0]' => $user->id,
                                            'from_date' => request()->get('from_date'),
                                            'to_date' => request()->get('to_date'),
                                        ]) }}">
                                        <p class="font-weight-bold font-medium-2 mb-0">
                                            {{ $user->leadsYouCreated->count() }}
                                        </p>
                                        <span class="">{{ __('Leads') }}</span>
                                    </a>
                                </div>

                                @if ($user->teamsILead->count())
                                    <div class="following">
                                        <p class="font-weight-bold font-medium-2 mb-0">
                                            {{ $user->teamsILead->count() }}
                                        </p>
                                        <span class="">{{ __('Teams') }}</span>
                                    </div>
                                @endif

                                <div class="followers">
                                    <p class="font-weight-bold font-medium-2 mb-0">
                                        {{ $user->allEventsOnMyCreatedLeadsCount() }}
                                    </p>
                                    <span class="">{{ __('Events') }}</span>
                                </div>

                            </div>

                            <hr class="my-2">

                            <div class="accordion" id="accordionExample" data-toggle-hover="true">
                                <div class="collapse-margin">
                                    <div class="card-header"
                                        id="events-{{ Illuminate\Support\Str::slug($user->username) }}"
                                        data-toggle="collapse" role="button"
                                        data-target="#his-events-{{ Illuminate\Support\Str::slug($user->username) }}"
                                        aria-expanded="false"
                                        aria-controls="his-events-{{ Illuminate\Support\Str::slug($user->username) }}">
                                        <span class="lead collapse-title collapsed">
                                            {{ __('His Events') }}
                                        </span>

                                        <x-badges.primary text="{{ $user->myCreatedLeadsEvents()->count() }}" />
                                    </div>

                                    <div id="his-events-{{ Illuminate\Support\Str::slug($user->username) }}"
                                        class="collapse"
                                        aria-labelledby="events-{{ Illuminate\Support\Str::slug($user->username) }}"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center flex-wrap" style="gap: 5px">
                                                @foreach ($user->myCreatedLeadsEventsReport() as $event)
                                                    <a href="{{ route('leads.index', ['creators_ids[0]' => $user->id, 'events_ids[0]' => $event->event_name]) }}"
                                                        class="chip chip-lg mr-1">
                                                        <div class="chip-body">
                                                            <div class="avatar bg-primary">
                                                                <span>{{ $event->count }}</span>
                                                            </div>
                                                            <span class="chip-text">{{ $event->event_name }}</span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($user->teamsILead->count())
                                    @php
                                        $username_prefix = Illuminate\Support\Str::slug($user->username);
                                    @endphp
                                    <div class="collapse-margin">
                                        <div class="card-header" id="team-{{ $username_prefix }}" data-toggle="collapse"
                                            role="button" data-target="#his-team-events-{{ $username_prefix }}"
                                            aria-expanded="false" aria-controls="his-team-events-{{ $username_prefix }}">
                                            <span class="lead collapse-title collapsed">
                                                {{ __('His team\'s events') }}
                                            </span>

                                            <x-badges.primary
                                                text="{{ $user->eventsOnMyTeamsMembersCreatedLeads()->count() }}" />
                                        </div>
                                        <div id="his-team-events-{{ $username_prefix }}" class="collapse"
                                            aria-labelledby="team-{{ $username_prefix }}" data-parent="#accordionExample">
                                            <div class="card-body">

                                                <div class="d-flex align-items-center flex-wrap" style="gap: 5px">
                                                    @foreach ($user->eventsOnMyTeamsMembersCreatedLeadsReport() as $event)
                                                        <a href="{{ route('leads.index', ['assigned_to_team' => $user->id, 'events_ids[0]' => $event->event_name]) }}"
                                                            class="chip chip-lg mr-1">
                                                            <div class="chip-body">
                                                                <div class="avatar bg-primary">
                                                                    <span>{{ $event->count }}</span>
                                                                </div>
                                                                <span class="chip-text">{{ $event->event_name }}</span>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bottom-actions mt-2">
        <div class="app-pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection

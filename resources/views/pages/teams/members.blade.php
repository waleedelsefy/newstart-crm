@extends('layouts.app')

@section('title', __('Team Members'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('teams.index') }}">{{ __('Teams List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@push('styles')
    <style>
        .team-members-count {
            font-size: 20px;
            display: block;
        }

        .member-card label {
            cursor: pointer;
            padding: 6px;
        }

        .member-card input {
            display: none;
        }

        .member-card input:checked+label,
        .member-card label:hover {
            background: #7267f02c;
            border-radius: 6px;
            transition: .5s;
        }

        .member-card img {
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .member-card .member-name {
            font-size: 14px;
            font-weight: bold;
        }

        .member-card .member-title {
            font-size: 12px;
        }
    </style>
@endpush


@section('content')

    <div class="mb-1 d-flex align-items-center gap-1">
        <span class="team-members-count">
            <x-badges.primary text="{{ $team->members->count() }}" icon="feather icon-users" />
        </span>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('teams.update-members', $team) }}" method="POST">
                @csrf
                @method('PUT')

                @error('members')
                    <x-alerts.danger :message="$message" />
                @enderror

                <div class="row">
                    @foreach ($employees as $employee)
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="card member-card text-center">
                                <input type="checkbox" name="members[]" @checked(in_array($employee->id, [...$team->members->pluck('id')]))
                                    id="{{ $employee->username }}-{{ $employee->id }}" value="{{ $employee->id }}">
                                <label for="{{ $employee->username }}-{{ $employee->id }}">
                                    <img src="{{ $employee->getPhoto() }}" class="w-100" alt="{{ $employee->username }}">
                                    <h4 class="member-name">{{ $employee->name }}</h4>
                                    <span class="member-title">{{ $employee->jobTitle() }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
            </form>
        </div>
    </div>


@endsection

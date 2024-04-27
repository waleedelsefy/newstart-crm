@extends('layouts.app')

@section('title', $team->name)

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
            color: #2c2c2c;
        }
    </style>
@endpush

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('teams.index') }}">{{ __('Teams List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection



@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($team->members as $member)
                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <a href="{{ route('users.show', $member) }}" class="card member-card text-center">
                            <img src="{{ $member->getPhoto() }}" class="w-100" alt="{{ $member->username }}">
                            <h4 class="member-name">{{ $member->name }}</h4>
                            <span class="member-title">{{ $member->jobTitle() }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection

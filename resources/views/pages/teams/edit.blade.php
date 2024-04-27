@extends('layouts.app')

@section('title', __('Edit Team'))

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
            <form action="{{ route('teams.update', $team) }}" method="POST">
                @include('pages.teams._form')
            </form>
        </div>
    </div>


@endsection

@extends('layouts.app')

@section('title', __('Add New Team'))

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
            <form action="{{ route('teams.store') }}" method="POST">
                @include('pages.teams._form')
            </form>
        </div>
    </div>


@endsection

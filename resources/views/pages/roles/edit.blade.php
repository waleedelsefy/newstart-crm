@extends('layouts.app')

@section('title', __('Edit Role'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('roles.index') }}">{{ __('Roles List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @include('pages.roles._form')
            </form>
        </div>
    </div>


@endsection

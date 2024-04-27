@extends('layouts.app')

@section('title', __('Add New User'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('users.index') }}">{{ __('Users List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @include('pages.users._form')
            </form>
        </div>
    </div>


@endsection

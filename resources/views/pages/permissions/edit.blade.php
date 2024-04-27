@extends('layouts.app')

@section('title', __('Edit Permission'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('permissions.index') }}">{{ __('Permissions List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                @include('pages.permissions._form')
            </form>
        </div>
    </div>


@endsection

@extends('layouts.app')

@section('title', __('Create Branch'))

@section('breadcrumb')
    @parent

    {{-- <li class="breadcrumb-item">
        <a href="{{ route('prev.index') }}">{{ __('Prev page') }}</a>
    </li> --}}

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))

    </li>
@endsection


@section('content')
@endsection

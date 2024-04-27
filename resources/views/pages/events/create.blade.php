@extends('layouts.app')

@section('title', __('Add New Event'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('events.index') }}">{{ __('Events List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST">
                @include('pages.events._form')
            </form>
        </div>
    </div>


@endsection

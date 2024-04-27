@extends('layouts.app')

@section('title', __('Add New Interest'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('interests.index') }}">{{ __('Interests List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('interests.store') }}" method="POST">
                @include('pages.interests._form')
            </form>
        </div>
    </div>


@endsection

@extends('layouts.app')

@section('title', __('Add New Developer'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('developers.index') }}">{{ __('Developers List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('developers.store') }}" method="POST">
                @include('pages.developers._form')
            </form>
        </div>
    </div>


@endsection

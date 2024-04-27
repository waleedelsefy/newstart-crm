@extends('layouts.app')

@section('title', __('Add New Source'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('sources.index') }}">{{ __('Sources List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sources.store') }}" method="POST">
                @include('pages.sources._form')
            </form>
        </div>
    </div>


@endsection

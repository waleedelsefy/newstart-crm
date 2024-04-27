@extends('layouts.app')

@section('title', __('Add New Branch'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('branches.index') }}">{{ __('Branches List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('branches.store') }}" method="POST">
                @include('pages.branches._form')
            </form>
        </div>
    </div>


@endsection

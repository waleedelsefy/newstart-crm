@extends('layouts.app')

@section('title', __('Edit Branch'))

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
            <form action="{{ route('branches.update', $branch) }}" method="POST">
                @include('pages.branches._form')
            </form>
        </div>
    </div>


@endsection

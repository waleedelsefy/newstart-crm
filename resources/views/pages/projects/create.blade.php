@extends('layouts.app')

@section('title', __('Add New Project'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('projects.index') }}">{{ __('Projects List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST">
                @include('pages.projects._form')
            </form>
        </div>
    </div>


@endsection

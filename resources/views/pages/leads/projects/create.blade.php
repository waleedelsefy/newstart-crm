@extends('layouts.app')

@section('title', __('Add New Project'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('leads.index') }}">{{ __('Leads List') }}</a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('leads.projects.index', $lead) }}">{{ __('Projects List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.projects.store', $lead) }}" method="POST">
                @include('pages.leads.projects._form')
            </form>
        </div>
    </div>


@endsection
